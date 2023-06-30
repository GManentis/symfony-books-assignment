<?php

namespace App\Entity;

use App\Repository\BookLibraryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookLibraryRepository::class)]
class BookLibrary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookLibraries')]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'bookLibraries')]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    private ?Library $library = null;

    #[ORM\Column]
    private ?bool $rented = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getLibrary(): ?library
    {
        return $this->library;
    }

    public function setLibrary(?library $library): static
    {
        $this->library = $library;

        return $this;
    }

    public function isRented(): ?bool
    {
        return $this->rented;
    }

    public function setRented(bool $rented): static
    {
        $this->rented = $rented;
        return $this;
    }
}
