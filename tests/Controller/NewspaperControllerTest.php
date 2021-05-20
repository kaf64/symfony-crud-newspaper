<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewspaperControllerTest extends WebTestCase{

    private $client;

    protected function setUp(): void{
        $this->client = static::createClient();
    }

    public function testStatusNewspaper(){
        
        $this->client->request('GET', '/newspapers');
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAddNewNewspaperForm(){
        //generate from route
        $crawler= $this->client->request('GET', '/newspaper/new');
        
    $formCrawlerNode = $crawler->selectButton('Add new newspaper');
    $form = $formCrawlerNode->form();


    $form=$formCrawlerNode->form([
        'newspaper_form[name]'=>'New newspaper tested',
        'newspaper_form[description]'=>'New newspaper added by test',
    ]);

    // submit the form
    $this->client->followRedirects();
    
    $crawler = $this->client->submit($form);

    // check if created newspaper is shown after submit
    
    $response=$this->client->getResponse()->getContent();

    /*
    $this->assertStringContainsString(
        'New newspaper tested', $response);
    }
    */
    $this->assertStringContainsString('New newspaper tested', $response, "no newspaper name found in response");
    $this->assertStringContainsString('New newspaper added by test', $response, "no newspaper description found in response");

    }

}
