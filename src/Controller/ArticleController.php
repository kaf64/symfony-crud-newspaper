<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;

use App\Form\ArticleFormType;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//for Form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//for handling exceptions
use \Doctrine\DBAL\DBALException;


class ArticleController extends AbstractController{
    /**
    *@Route("/articles",name="article_list", methods={"GET"})
    **/
    public function index(){
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('articles/index.html.twig',array('articles'=>$articles));
    }

    /**
    * @Route("/article/new",name="article_new", methods={"GET", "POST"})
    */
     public function new(Request $request){
        $manager=$this->getDoctrine()->getManager();
        $article=new Article();
        $form=$this->createForm(ArticleFormType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
        $manager->getConnection()->beginTransaction();
            try{
                $article=$form->getData();
                $manager->persist($article);
                $manager->flush();
                $manager->getConnection()->commit();
            }catch(DBALException $e){
                $manager->rollback();
                $this->addFlash('danger', 'Article adding error, information: '.$e->getMessage());
            } 
            return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/new.html.twig',array('form'=>$form->createView()));
     }

    /**
     * @Route("/article/edit/{id}",name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id){
        $manager=$this->getDoctrine()->getManager();
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $article=new Article();
        $article=$repo->find($id);
        $form=$this->createForm(ArticleFormType::class,$article,array(
            'save_button_label' =>'Save changes',
        ));
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){            
            $manager->getConnection()->beginTransaction();
            try{
                $manager->persist($article);
                $manager->flush();
                $manager->getConnection()->commit();
            }catch(DBALException $e){
                $manager->rollback();
                $this->addFlash('danger', 'Article adding error, information: '.$e->getMessage());
            } 
            return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/edit.html.twig',array('form'=>$form->createView()));
     }

    /**
     * @Route("/article/delete/{id}",name="article_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, $id){
        
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $article=$repo->find($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->getConnection()->beginTransaction();
        try{
            $manager->remove($article);
            $manager->flush();
            $manager->getConnection()->commit();
        }catch(DBALException $e){
            $manager->rollback();
            $this->addFlash('danger', 'Article deleting error, information: '.$e->getMessage());
        }    
        return $this->redirectToRoute('article_list');  
    }
    
    /**
    *@Route("/article/{id}",name="article_show") 
    **/
    public function show($id){
        $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('articles/show.html.twig',array('article'=>$article));
       
    }

}
    
?>