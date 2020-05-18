<?php
namespace App\Controller;

use App\Entity\Author;
use App\Entity\Article;
use App\Entity\Newspaper;
use App\Form\AuthorFormType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
//for Form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//for handling exceptions
use \Doctrine\DBAL\DBALException;



class AuthorController extends AbstractController{
    /**
    *@Route("/authors",name="author_list", methods={"GET"})
    **/
    public function index(){
        $repo=$this->getDoctrine()->getRepository(Author::class);
        $authors = $repo->findAll();    
        return $this->render('authors/index.html.twig',array('authors'=>$authors));
    }

    /**
    * @Route("/author/new",name="author_new", methods={"GET", "POST"})
    */
    public function new(Request $request){
        $manager=$this->getDoctrine()->getManager();
        $author=new Author();
        $form=$this->createForm(AuthorFormType::class);
            $form->handleRequest($request);
            if($form->isSubmitted()&& $form->isValid()){
                $author=$form->getData();
                $manager->getConnection()->beginTransaction();
                try{
                    $manager->persist($author);
                    $manager->flush();
                    $manager->getConnection()->commit();
                }catch(DBALException $e){
                    $manager->rollback();
                    $this->addFlash('danger', 'Author adding error, information: '.$e->getMessage());
                } 
                return $this->redirectToRoute('author_list');
            }

        return $this->render('authors/new.html.twig',array('form'=>$form->createView()));
     }

    /**
    * @Route("/author/edit/{id}",name="author_edit", methods={"GET", "POST"})
    */
    public function edit(Request $request, $id){
        $manager=$this->getDoctrine()->getManager();
        $author = new Author();
        $repo=$this->getDoctrine()->getRepository(Author::class);
        $author=$repo->find($id);
        $form=$this->createForm(AuthorFormType::class,$author,array(
            'save_button_label' =>'Save changes',
        ));
            $form->handleRequest($request);
            if($form->isSubmitted()&& $form->isValid()){
                $manager->getConnection()->beginTransaction();
                try{
                    $manager->persist($author);
                    $manager->flush();
                    $manager->getConnection()->commit();
                }catch(DBALException $e){
                    $manager->rollback();
                    $this->addFlash('danger', 'Author adding error, information: '.$e->getMessage());
                }                 
            return $this->redirectToRoute('author_list');
            }

        return $this->render('authors/edit.html.twig',array('form'=>$form->createView()));
     }

    /**
     * @Route("/author/delete/{id}",name="author_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, $id){
        $repo=$this->getDoctrine()->getRepository(Author::class);
        $author=$repo->find($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->getConnection()->beginTransaction();
        try{
            $manager->remove($author);
            $manager->flush();
            $manager->getConnection()->commit();
        }catch(DBALException $e){
            $manager->rollback();
            $this->addFlash('danger', 'Author deleting error, information: '.$e->getMessage());
        }    
        return $this->redirectToRoute('author_list');
    }
    
    /**
    *@Route("/author/{id}",name="author_show", methods={"GET", "POST"}) 
    **/
    public function show($id,Request $request) {
      $repo=$this->getDoctrine()->getRepository(Author::class);
        
      $author=$repo->find($id);
      
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) { 
            $jsonData = array();  
            $author_articles=$author->getArticles();
            foreach($author_articles as $article){
                $temp=array();
                $temp['title']=$article->getTitle();
                $temp['id']=$article->getId();
                $temp['publish_date']=$article->getPublishDate();
                array_push($jsonData,$temp);   
            }
        return new JsonResponse($jsonData); 
        }else{
        return $this->render('authors/show.html.twig',array('author'=>$author));
        }
    }


}