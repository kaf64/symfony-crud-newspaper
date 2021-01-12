<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase{

    private $client;

    protected function setUp(){
        $this->client = static::createClient();
    }

    public function testStatusIndex(){
        
        $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCssLink(){
        
       $crawler= $this->client->request('GET', '/');
        $link = $crawler
        ->filter('a:contains("Greet")') // find all links with the text "Greet"
        ->eq(0) // select the second link in the list
        ->link()
        ;

// and click it
    $crawler = $this->client->click($link);   

    $form = $crawler->selectButton('submit')->form();

    // set some values
    $form['name'] = 'Lucas';
    $form['form_name[subject]'] = 'Hey there!';

    // submit the form
    $crawler = $this->client->submit($form);
    }

    // TODO add testing form new
    // new author
    //$this->assertSelectorTextContains('html h1.title', 'Hello World');
    // new newspaper    
}