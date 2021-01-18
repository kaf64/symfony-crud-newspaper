<?
namespace App\Tests\Entity;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Newspaper;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase{

    private $author;
    private $newspaper;

    protected function setUp(): void{
        $this->newspaper=new Newspaper("New newspaper","lorem ipsum dolor sit amet");
        $this->author=new Author("Jane Doe","Jane Doe was born in USA...",$this->newspaper);
    }

    public function testCreateArticleWithoutHTML(){
        $article= new Article();
        $article->setTitle("Test Article Title");
        $article->setBody("Test Article Body");
        $article->setAuthor($this->author);

        $this->assertEquals("Test Article Title",$article->getTitle());
        $this->assertEquals("Test Article Body",$article->getBody());
        $this->assertSame($this->author,$article->getAuthor());
        $this->assertSame($this->newspaper,$article->getAuthor()->getNewspaper());
    }

    public function testArticlerWithHTML(){
        $article= new Article();
        $article->setTitle("<b>Test Article Title</b>");
        $article->setBody("<p>Test Article Body</p>");
        $article->setAuthor($this->author);

        $this->assertEquals("Test Article Title", $article->getTitle());
        $this->assertEquals("<p>Test Article Body</p>", $article->getBody());
    }

    
    public function testArticleConstructor(){
        $publish_date = new \DateTime();
        $article=new Article("Test Title","Test body",$this->author,$publish_date);

        $this->assertEquals("Test Title", $article->getTitle());
        $this->assertEquals("Test body", $article->getBody());
        $this->assertSame($publish_date, $article->getPublishDate());
        $this->assertSame($this->author, $article->getAuthor());
    }

}