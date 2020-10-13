<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Video;
use App\Entity\Image;
use App\Form\VideoType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
            ])
            ->add('description', TextType::class, [
                'label' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => false,
                'class' => Category::class,
                'choice_label' => 'title'
            ])
            ->add('image', FileType::class,[
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('video', CollectionType::class, [
                'entry_type' => VideoType::class,
                'label' => false
            ])

            //->add('video', TextType::class, [
            //    'required' => false,
            //   'mapped' => false,
            //    'label' => false,
            //])

        ;
    }



//->add('video', CollectionType::class, [
//                'entry_type' => UrlType::class,
//                'entry_options' => [
//                    'attr' => [ 'class' => 'movies-box' ],
//                ],
//                'allow_add' => true,
//                'allow_delete' => true,
//                'prototype' => true,
//                'label' => false,
//            ])

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
