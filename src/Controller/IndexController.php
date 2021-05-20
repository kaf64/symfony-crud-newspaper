<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Newspaper;
use App\Entity\Author;
use App\Entity\Article;


class IndexController extends AbstractController
{
    /** 
     * @Route("/", name="index")
     */
    public function index()
    {
        $doctrine=$this->getDoctrine();
        $authors=$doctrine->getRepository(Author::class)->findAll();
        $newspapers=$doctrine->getRepository(Newspaper::class)->findAll();
        $articles=$doctrine->getRepository(Article::class)->findAll();
        
        return $this->render('index/index.html.twig', array('authors'=>$authors,'newspapers'=>$newspapers,'articles'=>$articles));
    }

    /**
     * @Route("/request", name="request_test")
     */
    public function req_test(){
        $client = static::createClient();
        $request = $this->client->request('GET', '/newspapers');
        dd($request);


    }
}
