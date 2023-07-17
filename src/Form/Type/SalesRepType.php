<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface as FormFormBuilderInterface;

class SalesRepType extends AbstractType
{
    public function buildForm(FormFormBuilderInterface $builder, array $options): void
    {
        $myOptions = [
            'required' => true,
        ];
        $builder
            ->add('name', TextType::class, $myOptions)
            ->add('familyName', TextType::class, $myOptions)
            ->add('email', TextType::class, $myOptions)
            ->add('phoneNumber', TextType::class, $myOptions)
        ;
    }
}


