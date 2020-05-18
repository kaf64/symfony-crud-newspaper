<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="text",length=100)
     * 
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * 
     */
    private $body;
    /**
     * @ORM\Column(type="datetime")
     */
    private $publish_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="Articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;



    // gets&sets



    public function getId(){
        return $this->id;
    }

    public function setId($value){
        $this->id=$value;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($value){
        $this->title=$value;
    }

    public function getBody(){
        return $this->body;
    }

    public function setBody($value){
        $this->body=$value;
    }



    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publish_date;
    }

    public function setPublishDate(\DateTimeInterface $date): self
    {
        $this->publish_date = $date;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

}
