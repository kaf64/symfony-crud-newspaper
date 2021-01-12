<?
namespace App\Tests\Entity;

use App\Entity\Newspaper;
use PHPUnit\Framework\TestCase;

class NewspaperTest extends TestCase{
    
    public function testNewspaperWithoutHTML(){
    $newspaper=new Newspaper();
    $newspaper->setName("New Yorker");
    $newspaper->setDescription("New Yorker is new newspaper from New York");
    $this->assertEquals("New Yorker", $newspaper->getName());
    $this->assertEquals("New Yorker is new newspaper from New York", $newspaper->getDescription());
    }
    
    public function testNewspaperWithHTML(){
    $newspaper=new Newspaper();
    $newspaper->setName("<b>New Yorker</b>");
    $newspaper->setDescription("<b>New Yorker is new newspaper from New York</b>");
    $this->assertEquals("New Yorker", $newspaper->getName());
    $this->assertEquals("<b>New Yorker is new newspaper from New York</b>", $newspaper->getDescription());
    }

    public function testNewspaperConstructor(){
        $newspaper=new Newspaper("New spaper","New spaper is new newspaper brand");

        $this->assertEquals("New spaper", $newspaper->getName());
        $this->assertEquals("New spaper is new newspaper brand", $newspaper->getDescription());
        }
}