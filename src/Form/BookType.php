<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('isbn')
            ->add('description')
            ->add('rented', CheckboxType::class, [
                'label' => 'Already Rented',
                'required' => false
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'placeholder' => '(Αγνωστος Συγγραφέας)',
                'choice_label' => function (Author $author) {
                    return $author->getFirstname() . ' ' . $author->getLastname();
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'library' => null
        ]);
    }
}
