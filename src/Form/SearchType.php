<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchType extends AbstractType
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $router = $this->router;

        $builder
            ->add('artist', EntityType::class, [
                'label' => 'Artiste',
                'class' => Artist::class,
                'choice_label' => 'name',
                'choice_value' => function ($artist) use ($router) {
                if ($artist)
                    return $router->generate('artist_show', ['id'=>$artist->getId()]);
                else
                    return '';
                },
                'attr' => [
                    'onchange' => 'location = this.options[this.selectedIndex].value;'
                ],

            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
                'choice_value' => function ($category) use ($router) {
                if ($category)
                    return $router->generate('category_show', ['id'=>$category->getId()]);
                else
                    return 'Sélectionnez';
                },
                'attr' => [
                    'onchange' => 'location = this.options[this.selectedIndex].value;'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}