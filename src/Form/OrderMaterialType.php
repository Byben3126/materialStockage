<?php

namespace App\Form;

use App\Entity\OrderMaterial;
use App\Entity\Materials;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderMaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('material', EntityType::class, [
            //     'class' => Materials::class,
            //     'choice_label' => 'name',
            // ])
            ->add('quantity', IntegerType::class, [
                'attr' => ['min' => 0],
                'label' => true, // Masquer le label pour un rendu plus propre
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderMaterial::class,
        ]);
    }
}
