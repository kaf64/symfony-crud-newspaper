<?php
namespace App\Controller;

use App\Entity\Newspaper;
use App\Form\NewspaperFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
//for request
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//for Form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//for handling exceptions
use \Doctrine\DBAL\DBALException;


class NewspaperController extends AbstractController{


    /**
    * @Route("/newspapers",name="newspaper_list", methods={"GET"})
     **/
    public function index(){
        $repo=$this->getDoctrine()->getRepository(Newspaper::class);
        $newspapers = $repo->findAll();
        return $this->render('newspapers/index.html.twig',array('newspapers'=>$newspapers));
    }

     /**
     * @Route("/newspaper/new",name="newspaper_new", methods={"GET","POST"})
     */
    public function new(Request $request){
        $newspaper=new Newspaper();
        $form=$this->createForm(NewspaperFormType::class, $newspaper);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $newspaper=$form->getData();
            $manager=$this->getDoctrine()->getManager();
            $manager->getConnection()->beginTransaction();
            try{
                $manager->persist($newspaper);
                $manager->flush();
                $manager->getConnection()->commit();
            }catch(DBALException $e){
                $manager->rollback();
                $this->addFlash('danger', 'Newspaper adding error, information: '.$e->getMessage());
            } 
            return $this->redirectToRoute('newspaper_list');
        }
        return $this->render('newspapers/new.html.twig',array('form'=>$form->createView()));
     }

    /**
     * @Route("/newspaper/edit/{id}",name="newspaper_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id){
        $newspaper = new Newspaper();
        $repo=$this->getDoctrine()->getRepository(Newspaper::class);
        $newspaper=$repo->find($id);
        $form=$this->createForm(NewspaperFormType::class,$newspaper,array(
            'save_button_label' =>'Save changes',
        ));
        $form->handleRequest($request);
        $manager=$this->getDoctrine()->getManager();
        $manager->getConnection()->beginTransaction();
        if($form->isSubmitted()&& $form->isValid()){
            try{
                $manager->flush();
                $manager->getConnection()->commit();
            }catch(DBALException $e){
                $manager->rollback();
                $this->addFlash('danger', 'Newspaper editing error, information: '.$e->getMessage());
            }
        return $this->redirectToRoute('newspaper_list');
        }
        return $this->render('newspapers/edit.html.twig',array('form'=>$form->createView()));
     }

    /**
     * @Route("/newspaper/delete/{id}",name="newspaper_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, $id){
        $repo=$this->getDoctrine()->getRepository(Newspaper::class);
        $newspaper=$repo->find($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->getConnection()->beginTransaction();
        try{
            $manager->remove($newspaper);
            $manager->flush();
            $manager->getConnection()->commit();
        }catch(DBALException $e){
            $manager->rollback();
            $this->addFlash('danger', 'Newspaper deleting error, information: '.$e->getMessage());
        }    
        return $this->redirectToRoute('newspaper_list');
    }
    
    /**
     *@Route("/newspaper/{id}",name="newspaper_show") 
     **/
    public function show($id){
        $repo=$this->getDoctrine()->getRepository(Newspaper::class);
        $newspaper=$repo->find($id);
        return $this->render('newspapers/show.html.twig',array('newspaper'=>$newspaper));
    }
    
}