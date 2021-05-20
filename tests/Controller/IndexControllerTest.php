<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase{

    private $client;

    protected function setUp(): void{
        $this->client = static::createClient();
    }

    public function testStatusIndex(){
        
        $crawler = $this->client->request('GET', '/');
        //$this->assertResponseIsSuccessful();
        //$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        //$this->assertEquals(200, $request->getStatusCode());
        $this->assertResponseIsSuccessful();
        //dd($request);
    }

    public function testMenuLinks(){
        $crawler = $this->client->request('GET', '/');
        $links = $crawler->filter('div[class="dropdown-menu"] a[class="dropdown-item"]')->links(); // find all links in menu"
        
        // separate links list from testing symbols
        echo("\nFound links:\n");

        foreach ($links as $link){
            //show found link
            echo("link: " . $link->getUri()."\n");
            $this->client->request('GET', '/');
            $crawler = $this->client->click($link);
            $this->client->followRedirects();

            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        }
    
    }
    // TODO add testing form new
    // new author
    //$this->assertSelectorTextContains('html h1.title', 'Hello World');
    // new newspaper    
}