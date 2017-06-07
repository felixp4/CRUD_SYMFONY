<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

    /**
     * @Route("/create", name="create")
     * @param $request
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/form.html.twig', array(
            'form' => $form->CreateView(),
        ));
    }

    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository(Article::Class);
        $articles = $articleRepository->findAll();

        return $this->render('default/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * @Route("/update/{id}", name="update")
     * @param $request
     * @return RedirectResponse|Response
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        $articleRepository = $em->getRepository(Article::Class);
        $article = $articleRepository->find($id);

        $updateForm = $this->createForm(ArticleType::Class, $article);
        $updateForm->handleRequest($request);

        if ($updateForm->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/form.html.twig', array(
            'form' => $updateForm->CreateView(),
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param $request
     * @return RedirectResponse|Response
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository(Article::Class);

        $id = $request->get('id');
        $article = $articleRepository->find($id);

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
