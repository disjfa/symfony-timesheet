<?php

namespace App\Form;

use App\Entity\Organization;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('organization', EntityType::class, [
            'class' => Organization::class,
            'choice_label' => 'name',
            'placeholder' => 'Choose an organization',
            'autocomplete' => true,
            'multiple' => true,
            'required' => false,
        ]);
        $builder->add('user', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'name',
            'placeholder' => 'Choose a user',
            'autocomplete' => true,
            'multiple' => true,
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): ?string
    {
        return '';
    }
}
