<?php
// src/Service/YetinderService.php
namespace App\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\Form\Form;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class YetinderService
{
    private $connection;
    private $params;

    public function __construct(Connection $connection,ParameterBagInterface $params) {
        $this->connection = $connection;
        $this->params = $params;
    }

    /**
    * vypis $c nejlepsich dle hodnoceni
    */
    public function listTop(int $c)
    {
        $data = $this
            ->connection
            ->createQueryBuilder()
            ->select('id,name,photo,rating')
            ->from('yeti')
            ->where('rating>0')
            ->orderBy('rating')
            ->setMaxResults($c)
            ->execute()
            ->fetchAllAssociative();
        return $data;
    }

    /**
    * detail yetiho
    */
    public function detail(int $id=null)
    {
        $data = $this
            ->connection
            ->createQueryBuilder()
            ->select('id,name,photo,rating,description,height,weight,address')
            ->from('yeti');
        
        if ($id) //je zadan parametr id, vypis detail tohoto    
        {
            $data=$data
                ->where('id=?')
                ->setParameter(0, $id);
        }
        else //neni zadan parametr id, vypis nahodneho
        {
            $c = $this
            ->connection
            ->createQueryBuilder()
            ->select('count(1)')
            ->from('yeti')
            ->execute()
            ->fetchOne();

            $data=$data
            ->setFirstResult(random_int(0, $c-1));
        }

        $data=$data
            ->execute()
            ->fetchAssociative();
        
        return $data;
    }

    /**
    * pridani yetiho z formulare
    */
    public function add(Form $form,SluggerInterface $slugger)
    {
        $photo = $form->get('photo')->getData();
        $newFilename=null;
        if ($photo) {
            $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
            try {
                $photo->move(
                    $this->params->get('image_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }
        }
      
        $data=$form->getData();
        $this
            ->connection
            ->createQueryBuilder()
            ->insert('yeti')
            ->setValue('name', '?')
            ->setValue('description', '?')
            ->setValue('height', '?')
            ->setValue('weight', '?')
            ->setValue('address', '?')
            ->setValue('photo', '?')
            ->setParameter(0, $data['name'])
            ->setParameter(1, $data['description'])
            ->setParameter(2, $data['height'])
            ->setParameter(3, $data['weight'])
            ->setParameter(4, $data['address'])
            ->setParameter(5, $newFilename)
            ->execute();
        return $this->connection->lastInsertId();
    }

    /**
    * pridani hodnoceni yetiho $id
    */
    public function rate(int $id,int $r)
    {
        //vlozeni hodnoceni do tabulky rating
        $this
            ->connection
            ->createQueryBuilder()
            ->insert('rating')
            ->setValue('idyeti', '?')
            ->setValue('rdate', '?')
            ->setValue('rval', '?')
            ->setParameter(0, $id)
            ->setParameter(1, date("Y-m-d"))
            ->setParameter(2, $r)
            ->execute();

        //vypocet aktualniho hodnoceni jako prumeru ze vsech hodnoceni yetiho $id z tabuky rating
        $c = $this
            ->connection
            ->createQueryBuilder()
            ->select('sum(rval)/count(1)')
            ->from('rating')
            ->where('idyeti=?')
            ->setParameter(0, $id)
            ->execute()
            ->fetchOne();
            
        //auktualizace hodnoceni do tabulky yeti
        $this
            ->connection
            ->createQueryBuilder()
            ->update('yeti')
            ->set('rating', '?')
            ->where('id=?')
            ->setParameter(0, $c)
            ->setParameter(1, $id)
            ->execute();        
    }
 
    /**
    * zobrazeni grafu- prumerne hodnoceni k datu
    */
    public function chart(ChartBuilderInterface $chartBuilder)
    {
        //prumerne hodnoceni dle seskupeneho data
        $data = $this
            ->connection
            ->createQueryBuilder()
            ->select('rdate,sum(rval)/count(1) AS rval')
            ->from('rating')
            ->orderBy('rdate')
            ->groupBy('rdate')
            ->execute()
            ->fetchAllAssociative();

        $chart = $chartBuilder
            ->createChart(Chart::TYPE_LINE)
            ->setData([
                'labels' => array_column($data,'rdate'),
                'datasets' => [
                    [
                        'label' => 'průměrné hodnocení',
                        'backgroundColor' => 'rgb(255, 99, 132)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => array_column($data,'rval'),
                    ],
                ],
            ])
            ->setOptions([
                'scales' => [
                    'y' => [
                        'suggestedMin' => 0,
                        'suggestedMax' => 5,
                    ],
                ],
            ]);

        return $chart;
    }
}