<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Tache;
use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('projet', EntityType::class, ['class'=>Projet::class, 'expanded'=>false])
           // ->add('prestataire')
           ->add('prestataire', EntityType::class, ['class'=>Personne::class, 'expanded'=>false, "required" =>false, "choice_filter" =>'isPrestataire'])
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
