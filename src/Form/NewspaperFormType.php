<?php

namespace App\Form;

use App\Entity\Newspaper;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewspaperFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add("name", TextType::class, array('attr'=>array('class'=>'form-control')))
        ->add("description", TextareaType::class, array('attr'=>array('class'=>'form-control')))
        ->add("save", SubmitType::class, array('label'=>$options['save_button_label'],
        'attr'=>array('class'=>'btn btn-primary mt-3')))
    ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Newspaper::class,
            'save_button_label'=>'Add new newspaper',
        ]);
    }
}