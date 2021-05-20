<?php
namespace App\Tests;

use App\DataFixtures\TestArticleFixture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase{

    private $client;

    protected function setUp(): void{
        $this->client = static::createClient();
    }

    public function testStatusAtricle(){
        $this->client->request('GET', '/articles');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAddNewArticleForm(){
        
        //generate from route
    $crawler= $this->client->request('GET', '/article/new');
        
    $formCrawlerNode = $crawler->selectButton('Add new article');
    $form = $formCrawlerNode->form();

    $date = new \DateTime();
    $form=$formCrawlerNode->form([
        'article_form[title]'=>'New Article edded by form',
        'article_form[body]'=>'lorem ipsum dolor sit amet',
        //'article_form[publish_date]'=> $date->createFromFormat('dd-MM-YYYY HH:mm', '01-05-2021 12:20'),
        'article_form[publish_date]'=> '01-05-2021 12:20',
    ]);
    //$form['article_form[author]']->select('1');
    $author_id = $crawler->filter("#article_form_author > option")->attr("value");
    //$author = $repo->findOneBy(['name' => 'Bruce Springsteen']);
    $form['article_form[author]']->select($author_id);

    // submit the form
    $this->client->followRedirects();
    
    $crawler = $this->client->submit($form);

    // check if created author is shown after submit
    $response=$this->client->getResponse()->getContent();

    $this->assertStringContainsString('New Article edded by form', $response, "no newspaper title found in response");
    $this->assertStringContainsString('lorem ipsum dolor sit amet', $response, "no newspaper body found in response");
    $this->assertStringContainsString('01-05-2021 12:20', $response, "no newspaper date found in response");
    
    }

}
