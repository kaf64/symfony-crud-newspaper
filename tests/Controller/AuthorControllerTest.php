<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorControllerTest extends WebTestCase{

    private $client;

    protected function setUp(): void{
        $this->client = static::createClient();
    }

    public function testStatusAuthors(){
        $this->client->request('GET', '/authors');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAddNewAuthorForm(){
        
        //generate from route
        $crawler= $this->client->request('GET', '/author/new');
        
    $formCrawlerNode = $crawler->selectButton('Add new author');
    $form = $formCrawlerNode->form();


    $form=$formCrawlerNode->form([
        'author_form[name]'=>'Bruce Springsteen',
        'author_form[bio]'=>'Born in the USA',
    ]);

    // submit the form
    $this->client->followRedirects();
    
    $crawler = $this->client->submit($form);

    // check if created author is shown after submit

    $response=$this->client->getResponse()->getContent();

    /*
    $this->assertStringContainsString(
        'New newspaper tested', $response);
    }
    */
    $this->assertStringContainsString('Bruce Springsteen', $response, "no author name found in response");
    $this->assertStringContainsString('Born in the USA', $response, "no author bio found in response");
    
    }

}
