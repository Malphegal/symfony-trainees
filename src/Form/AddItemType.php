<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $items = $options["data"]["items"];
        $builder
            ->add("items", ChoiceType::class, [
                "choices" => $items, "multiple" => false, "expanded" => false, "label" => "Module ", "mapped" => false
            ])
            ->add('duration', IntegerType::class, ["label" => "Durée (jour) "])
            ->add('submit', SubmitType::class, ["label" => "Ajouter"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
