<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text",length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text",length=500)
     */
    private $bio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Newspaper", inversedBy="Authors")
     */
    private $newspaper;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="author", orphanRemoval=true)
     */
    private $Articles;

    public function __construct()
    {
        $this->Articles = new ArrayCollection();
    }
   
    
    //setters&getters


    public function getId()
    {
        return $this->id;
    }

    public function setId($value){
        $this->id=$value;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setName($value){
        $this->name=$value;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function setBio($value){
        $this->bio=$value;
    }
  
    
    public function __toString(): string {
        return $this->name;
    }

    public function getNewspaper(): ?Newspaper
    {
        return $this->newspaper;
    }

    public function setNewspaper(?Newspaper $newspaper): self
    {
        $this->newspaper = $newspaper;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->Articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->Articles->contains($article)) {
            $this->Articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->Articles->contains($article)) {
            $this->Articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    
}
