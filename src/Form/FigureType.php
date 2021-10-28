<?php

namespace App\Form;

use App\Entity\Figure;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class)

            ->add('photo', CollectionType::class, [
                'entry_type' => PhotoType::class,
                'label' => false,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('video', CollectionType::class, [
                'entry_type' => VideoType::class,
                'label' => false,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('save', SubmitType::class);
    }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Figure::class,  'file_uri' => 'img/img1.jpg',]);
    }
}
