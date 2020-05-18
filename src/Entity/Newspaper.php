<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewspaperRepository")
 */
class Newspaper
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Author", mappedBy="newspaper")
     */
    private $Authors;

    public function __construct()
    {
        $this->Authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(): ?string
    {
        return $this->name;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthors(): Collection
    {
        return $this->Authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->Authors->contains($author)) {
            $this->Authors[] = $author;
            $author->setNewspaper($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        if ($this->Authors->contains($author)) {
            $this->Authors->removeElement($author);
            // set the owning side to null (unless already changed)
            if ($author->getNewspaper() === $this) {
                $author->setNewspaper(null);
            }
        }

        return $this;
    }
}
