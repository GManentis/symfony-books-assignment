<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\BookLibrary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookLibraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rented',CheckboxType::class,["required" => false])
            ->add('book',EntityType::class,[
                "class" => Book::class,
                "choice_label" => function(Book $book) {
                    return "{$book->getTitle()}";
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookLibrary::class,
        ]);
    }
}
