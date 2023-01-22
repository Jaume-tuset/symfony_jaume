<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MembreNouType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('cognom', TextType::class)
            ->add('email', TextType::class)
            ->add('dataNaixement', FileType::class, array('required' => false))
            ->add('imatgePerfil', TextType::class)
            ->add('equip', EntityType::class, array('class'=>Equip::class,'choice_label'=>'nom'))
            ->add('nota', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Enviar'));
    }
}

?>