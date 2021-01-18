<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorControllerTest extends WebTestCase{

    private $client;

    protected function setUp(): void{
        $this->client = static::createClient();
    }

    public function testNewAuthor(){
        
    }

}
