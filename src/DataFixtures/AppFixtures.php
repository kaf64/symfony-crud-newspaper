<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Newspaper;
use App\Entity\Author;
use App\Entity\Article;

use \Datetime;

 class AppFixtures extends Fixture
 {
     public function load(ObjectManager $manager)
     {
        //add newspapers
        $newspapers_names=array("Corriere della Sera","Reader’s Digest","Wired");
        for($k=0;$k<3;$k++){
            $newspaper=New Newspaper();
            $newspaper->setName($newspapers_names[$k]);
            $newspaper->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sed orci vel lorem interdum pellentesque. Duis leo nunc, gravida vitae condimentum nec, rutrum et nisi.");
            $manager->persist($newspaper);
        }
        $manager->flush();
        //adding authors
        $authors_names=array("John Smith","John Doe","Jane Smith");
        $newspapers=$manager->getRepository(Newspaper::class)->findAll();
        for($i=0;$i<3;$i++){
            $author=New Author();
            $author->setName($authors_names[$i]);
            $author->setBio("Lorem ipsum dolor sit amet, consectetur adipiscing elit");
            $author->setNewspaper($newspapers[$i]);
            $manager->persist($author);
        }
        $manager->flush();
        //adding articles
        $authors=$manager->getRepository(Author::class)->findAll();
        for($j=0;$j<10;$j++){
            $article=new Article();
            $article->setTitle("Article".($j+1));
            $article->setBody("<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit amet diam blandit, congue nisi ac, vulputate diam. Etiam id nunc velit. Sed congue at purus eu convallis. Nam interdum massa sed nisi finibus, nec condimentum mauris ultrices. Vivamus malesuada libero ut turpis imperdiet tempor. Maecenas vestibulum elementum massa, in pretium leo mattis sed. Nam imperdiet ut tortor vel ultricies. Suspendisse potenti. Ut vulputate felis sed neque efficitur tempor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>");
            $random_date_start=DateTime::createFromFormat("Y-m-d H:i","2020-01-01 00:00");
            $random_date_end=DateTime::createFromFormat("Y-m-d H:i","2020-12-31 23:59");
            $random_timestamp=mt_rand($random_date_start->getTimestamp(), $random_date_end->getTimestamp());
            $random_date = new DateTime();
            $random_date->setTimestamp($random_timestamp);
            $article->setPublishDate($random_date);
            //set random author based on modulo
            $article->setAuthor($authors[($j%3)]);
            $manager->persist($article);
        }
         $manager->flush();
     }
}
