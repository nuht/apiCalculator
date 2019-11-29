<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('save', SubmitType::class)
            // ->add('email', 'email')
            // ->add('username', null)
            // ->add('plainPassword', 'repeated', [
            //     'type' => 'password',

            //     'first_options' => ['label' => 'password'],
            //     'second_options' => ['label' => 'password_confirmation'],

            // ])
            // // ->add('save', SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection'   => false
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}