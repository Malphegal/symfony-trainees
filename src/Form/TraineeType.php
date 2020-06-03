<?php

namespace App\Form;

use App\Entity\Trainee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraineeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array(
                'attr' => array(
                    'class' => 'input-bottom'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('lastname', null, array(
                'attr' => array(
                    'class' => 'input-bottom'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('birthdate', BirthdayType::class, array(
                'attr' => array(
                    'class' => 'select-parent'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('city', null, array(
                'attr' => array(
                    'class' => 'input-bottom'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('phone', null, array(
                'attr' => array(
                    'class' => 'input-bottom'
                ),
                'row_attr' => array(
                    'class' => 'outer-input'
                )
            ))
            ->add('email', null, array(
                'attr' => array(
                    'class' => 'input-bottom'
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trainee::class,
        ]);
    }
}
