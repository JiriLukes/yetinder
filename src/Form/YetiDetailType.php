<?php
// src/Form/YetiDetailType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class YetiDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [ 'label' => 'Jméno' ])
            ->add('description', TextareaType::class, [ 'label' => 'Popis', 'required' => false ]) 
            ->add('height', TextType::class, [ 'label' => 'Výška', 'required' => false ])
            ->add('weight', TextType::class, [ 'label' => 'Hmotnost', 'required' => false ])
            ->add('address', TextType::class, [ 'label' => 'Bydliště', 'required' => false ])
            ->add('photo', TextType::class, [ 'label' => 'Fotografie', 'required' => false ])
            ->add('photo', FileType::class, [
                'label' => 'Fotografie',
                'required' => false, 

            ])
            ->add('save', SubmitType::class, [ 'label' => 'Uložit' ])
        ;
    }
}