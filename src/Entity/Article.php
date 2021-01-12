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

    public function __construct($title="",$body="", Author $author=null,\DateTime $publish_date=null)
    {
        $this->setTitle($title);
        $this->setBody($body);
        if($publish_date)$this->setPublishDate($publish_date);
        else $this->setPublishDate(new \DateTime());
        $this->setAuthor($author);

    }

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
        $this->title=strip_tags($value);
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

    public function setPublishDate(\DateTimeInterface $date=null): self
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
