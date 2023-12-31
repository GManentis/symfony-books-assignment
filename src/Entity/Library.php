<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $supervisorFirstname = null;

    #[ORM\Column(length: 255)]
    private ?string $supervisorLastname = null;

    #[ORM\OneToMany(mappedBy: 'library', targetEntity: BookLibrary::class, orphanRemoval: true)]
    private Collection $bookLibraries;

    public function __construct()
    {
        $this->bookLibraries = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getSupervisorFirstname(): ?string
    {
        return $this->supervisorFirstname;
    }

    public function setSupervisorFirstname(string $supervisorFirstname): static
    {
        $this->supervisorFirstname = $supervisorFirstname;

        return $this;
    }

    public function getSupervisorLastname(): ?string
    {
        return $this->supervisorLastname;
    }

    public function setSupervisorLastname(string $supervisorLastname): static
    {
        $this->supervisorLastname = $supervisorLastname;

        return $this;
    }

    /**
     * @return Collection<int, BookLibrary>
     */
    public function getBookLibraries(): Collection
    {
        return $this->bookLibraries;
    }

    public function addBookLibrary(BookLibrary $bookLibrary): static
    {
        if (!$this->bookLibraries->contains($bookLibrary)) {
            $this->bookLibraries->add($bookLibrary);
            $bookLibrary->setLibrary($this);
        }

        return $this;
    }

    public function removeBookLibrary(BookLibrary $bookLibrary): static
    {
        if ($this->bookLibraries->removeElement($bookLibrary)) {
            // set the owning side to null (unless already changed)
            if ($bookLibrary->getLibrary() === $this) {
                $bookLibrary->setLibrary(null);
            }
        }

        return $this;
    }
}
