<?php

namespace App\Form;

use App\Entity\Contract;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Prénom"
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom"
            ])
            ->add('email')
            ->add('dateStartAt', DateType::class, [
                "label" => "Date de début de contrat",
                'widget' => 'choice',
                'input'  => 'datetime_immutable'
            ])
            ->add('dateEndAt', DateType::class, [
                "label" => "Date de fin de contrat",
                'widget' => 'choice',
                'input'  => 'datetime_immutable'
            ])
            ->add('rent', TextType::class, [
                "label" => "loyer"
            ])
            ->add('caution')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
