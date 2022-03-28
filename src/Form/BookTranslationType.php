<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Translation\BookTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BookTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locale', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
        ;
    }
}