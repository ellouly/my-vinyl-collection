<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Titre de l'album"
            ])
            ->add('year', IntegerType::class, [
                'label' => "Année de sortie"
            ])
            ->add('image', TextType::class, [
                'label' => "Pochette"
            ])
            ->add('linkAudio', TextType::class, [
                'label' => "Lien audio",
            ])
            ->add('artist', EntityType::class, [
                'choice_label' => 'name',
                'label' => "Artiste",
                'class' => Artist::class
            ])
            ->add('category', EntityType::class, [
                'choice_label' => 'name',
                'label' => "Genre",
                'class' => Category::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
