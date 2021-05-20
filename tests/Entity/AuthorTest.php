<?
namespace App\Tests\Entity;

use App\Entity\Author;
use App\Entity\Newspaper;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase{

    public function testAuthorWithoutHTML(){
        $author=new Author();
        $author->setName("Jane Doe");
        $author->setBio("Jane Doe was born in USA...");
        $this->assertEquals("Jane Doe", $author->getName());
        $this->assertEquals("Jane Doe was born in USA...", $author->getBio());
    }
    public function testAuthorWithHTML(){
        $author=new Author();
        $author->setName("<b>Jane Doe</b>");
        $author->setBio("<p>Jane Doe was born in USA...</p>");
        $this->assertEquals("Jane Doe", $author->getName());
        $this->assertEquals("<p>Jane Doe was born in USA...</p>", $author->getBio());
    }

    public function testAuthorConstructor(){
        
        $newspaper=new Newspaper("New newspaper","lorem ipsum dolor sit amet");
        $author=new Author("Jane Doe","Jane Doe was born in USA...", $newspaper);
        $this->assertSame($newspaper,$author->getNewspaper());
        $this->assertEquals("Jane Doe", $author->getName());
        $this->assertEquals("Jane Doe was born in USA...", $author->getBio());
    }

    
    public function testCreateAuthorAndNewspaper(){
        $author=new Author();
        $author->setName("John Doe");
        $author->setBio("John Doe is young but promising author from Oklahoma");
        $newspaper=new Newspaper();
        $newspaper->setName("Newspaper1");
        $newspaper->setDescription("Newspaper1 is new newspaper no 1.");
        $author->setNewspaper($newspaper);

        $this->assertEquals("John Doe", $author->getName());
        $this->assertEquals("John Doe is young but promising author from Oklahoma", $author->getBio());
        
        $this->assertEquals("Newspaper1", $author->getNewspaper()->getName());
        $this->assertEquals("Newspaper1 is new newspaper no 1.", $author->getNewspaper()->getDescription());

    }
}