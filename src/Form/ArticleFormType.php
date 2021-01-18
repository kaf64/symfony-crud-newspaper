<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Article;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


//for Form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add("title", TextType::class, array('attr'=>array('class'=>'form-control')))
        ->add("body", TextareaType::class, array(
        //'widget'=>'single_text',
        'required' => false,
        'empty_data' => " ",
        'attr'=>array('class'=>'form-control tinyemce')))
        ->add("publish_date", DateTimeType::class,
        array(
            'widget'=>'single_text',
            'format' => 'YYYY-MM-dd HH:mm',
            'input'=>'datetime',
            'html5'=>false,
            'attr'=>array('class'=>'form-control datetimepicker-input','data-toggle'=>"datetimepicker",'data-target'=>"#article_form_publish_date"))
        )
        ->add("author", EntityType::class, array(
            'class'=>Author::class,
            'choice_label'=>'name',
        'attr'=>array('class'=>'form-control')))
        ->add("save", SubmitType::class, array('label'=>$options['save_button_label'],
        'attr'=>array('class'=>'btn btn-primary mt-3')));
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'save_button_label'=>'Add new article',
        ]);
    }
}