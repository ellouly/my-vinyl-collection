<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Category;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artist', EntityType::class, [
                'choice_label' => 'name',
                'class' => Artist::class
            ])
            ->add('category', EntityType::class, [
                'choice_label' => 'name',
                'class' => Category::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}