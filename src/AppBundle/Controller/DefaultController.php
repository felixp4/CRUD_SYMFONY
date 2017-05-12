<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Task;
use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
       /**
        * $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', TextType::Class)
            ->add('dueDate',DateType::Class)
            ->add('save', SubmitType::Class, array('label'=>'Create post'))
            ->getForm();
        */

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
           // 'form'=>$form->CreateView(),
        ]);
    }


    /**
     * @Route("/show", name="showform")
     */

    /**
     public function newAction(Request $request)
     {
         $task = new Task();
         // $task->setTask('Write a blog post');
         // $task->setDueDate(new \DateTime('tomorrow'));

         $form = $this->createFormBuilder($task)
             ->add('task', TextType::Class)
             ->add('dueDate', DateType::Class)
             ->add('save', SubmitType::Class, array('label' => 'Create post'))
             ->getForm();

         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()) {
             $task = $form->getData();

             return $this->redirectToRoute('homepage');
         }

         return $this->render('default/new.html.twig', array(
             // 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
             'form' => $form->CreateView(),
         ));
     }
     *
     * /

    /**
     * @Route("/showCRUD", name="showCRUD")
     */

    public function crudAction(Request $request)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('name', TextType::Class)
            ->add('description', TextType::Class)
            ->add('createdAt', DateType::Class)
            ->add('save', SubmitType::Class, array('label' => 'Create post object'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->CreateView(),
        ));
    }
}
