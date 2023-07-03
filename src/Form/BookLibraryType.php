<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\BookLibrary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Service\Maths;

class BookLibraryType extends AbstractType
{

    public function __construct(private Maths $math){

    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dd($this->math->add(1,1));
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
