<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'attr' => array(
                    'class' => 'input-bottom'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('seat', null, array(
                'attr' => array(
                    'class' => 'input-bottom'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('starts', null, array(
                'attr' => array(
                    'class' => 'select-parent'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('ends', null, array(
                'attr' => array(
                    'class' => 'select-parent'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'fancy-submit'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
