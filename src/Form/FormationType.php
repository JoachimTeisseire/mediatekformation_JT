<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Niveaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishedAt')
            ->add('title')
            ->add('description')
            ->add('miniature')
            ->add('picture')
            ->add('videoId')
            ->add('idniveau', EntityType::class, ['class' => Niveaux::class, 'choice_label' => 'niveau', 'multiple' => false, 'required' => true])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }

}
