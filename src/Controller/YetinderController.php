<?php
// src/Controller/YetinderController.php
namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

use App\Form\YetiDetailType;
use App\Service\YetinderService;

class YetinderController extends AbstractController
{
    /**
    * uvodni stranka s vypisem 10 nejlepsich dle hodnoceni
    */
    #[Route('/', name: 'home')]
    public function listTop(YetinderService $yts): Response
    {
        return $this->render('index.html.twig', [
            'data' => $yts->listTop(10),
        ]);        
    }

    /**
    * pridani noveho yetiho
    */
    #[Route('/add', name: 'add')]
    public function addNew(YetinderService $yts,Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(YetiDetailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $id=$yts->add($form,$slugger);
            return $this->redirectToRoute('tinder',['id'=>$id]);
        }        
        return $this->renderForm('add.html.twig', [ 'form' => $form, ]);        
    }

    /**
    * zobrazeni detailu yetiho s moznosti hodnoceni
    */
    #[Route('/tinder/{id}', name: 'tinder')]
    public function detail(YetinderService $yts, int $id=null): Response
    {
        return $this->render('tinder.html.twig', [
            'data' => $yts->detail($id),
        ]);        
    }

    /**
    * graf prumerneho hodnoceni za den
    */
    #[Route('/stats', name: 'stats')]
    public function stats(YetinderService $yts,ChartBuilderInterface $chartBuilder): Response
    {
        return $this->render('stats.html.twig', [
            'chart' => $yts->chart($chartBuilder),
        ]);        
    }

    /**
    * pridani hodnoceni k yetimu
    */
    #[Route('/rate/{id}/{r}', name: 'rate', requirements: ['id' => '\d+','r' => '\d+'])]
    public function rate(int $id, int $r, YetinderService $yts): Response
    {
        $yts->rate($id,$r);        
        $this->addFlash('success', 'Hodnocení bylo přidáno!');            
        return $this->redirectToRoute('tinder',['id'=>$id]);
    }

}