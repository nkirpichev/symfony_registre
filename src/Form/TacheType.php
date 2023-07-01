<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('dateDebut',DateType::class,array( 'widget'=>'single_text'))
            ->add('dateAchevement',DateType::class,array( 'widget'=>'single_text' , "required" =>false ))
            ->add('nombreHeure')
            ->add('commentaire')
            ->add('projet')
            ->add('prestataire')
            ->add('employe')
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
