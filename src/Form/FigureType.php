<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Figure;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class)

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
            ->add('group', EntityType::class, [
                'label' => 'Group',
                'required' => true,
                'placeholder' => 'Select group',
                'class' => Group::class,
                'choice_label' => function (Group $group) {
                    return strtoupper($group->getTitle());
                }
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => [
                    'class' => 'btn btn-outline-secondary text-uppercase',
                ]
            ]);
    }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Figure::class,  'file_uri' => 'img/img1.jpg',]);
    }
}
