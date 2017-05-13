<?php
// src/AppBundle/Form/ArticleType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::Class)
            ->add('description', TextType::Class)
            ->add('createdAt', DateType::Class)
            ->add('save', SubmitType::Class, array('label' => 'Create post object'))
        ;
    }
}