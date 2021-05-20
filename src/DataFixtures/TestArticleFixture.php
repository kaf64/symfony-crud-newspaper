<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Newspaper;
use App\Entity\Author;


 class TestArticleFixtures extends Fixture
 {
     public function load(ObjectManager $manager):void{
        //add newspapers
        $newspaper=New Newspaper("Wired");
        $newspaper->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sed orci vel lorem interdum pellentesque. Duis leo nunc, gravida vitae condimentum nec, rutrum et nisi.");       
        $manager->persist($newspaper);
        $manager->flush();
        //adding authors
        $author=New Author("Bruce Springsteen", "Born in USA");
        $author->setNewspaper($newspaper);
        $manager->persist($author);
        $manager->flush();
     }
}
