<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewspaperControllerTest extends WebTestCase{

    private $client;

    protected function setUp(){
        $this->client = static::createClient();
    }

    public function testIndex(){

    }

    public function testAddNewNewspaperForm(){
        //generate from route
        $crawler= $this->client->request('GET', '/newspaper/new');
        //drugi sposob
        $client = static::createClient();
        $crawler = $client->request('GET', '/newspaper/new');

    $formCrawlerNode = $crawler->selectButton('Add new newspaper');
    $form = $formCrawlerNode->form();
    //dump($form);

    // set some values
    //$form['form_newspaper[name]'] = 'New newspaper tested';
    //$form['newspaper[name]'] = 'New newspaper tested';
    //$form['name'] = 'New newspaper tested';
    //$form['description'] = 'New newspaper added by test';
    //$form['form_name[subject]'] = 'Hey there!';

    $form=$formCrawlerNode->form([
        'newspaper_form[name]'=>'New newspaper tested',
        'newspaper_form[description]'=>'New newspaper added by test',
    ]);

    // submit the form
    $client->followRedirects();
    
    $crawler = $client->submit($form);

    //po submicie sprawdź czy widać gazete
    
    //$this->assertGreaterThan(0, $crawler->filter('h1')->count());

    $response=$client->getResponse()->getContent();

    $this->assertStringContainsString(
        'New newspaper tested',$response);

    }

}
