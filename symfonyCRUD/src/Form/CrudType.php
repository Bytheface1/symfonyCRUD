<?php

namespace App\Form;

use App\Entity\Crud;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('correo')
            ->add('telefono')
            ->add('tipo', ChoiceType::class, [
                'placeholder' => false,
                'choices' => [
                    'Hotel' => "hotel",
                    'Pista' => "pista",
                    'Complemento' => "complemento",
                ]
            ])
            ->add('activo');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Crud::class,
        ]);
    }
}
