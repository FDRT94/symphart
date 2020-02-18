<?php

namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController

{
    /**
     * @Route("/", methods={"GET"}, name="article_list")
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render("articles/index.html.twig", array('articles' => $articles));
    }


    /**
     * @Route("/article/new/" , name="new_article", methods={"GET","POST"})
     * add validator and csrf later
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $article = New Article();

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array('attr' =>
                array('class' => 'form-control')))
            ->add('body', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

            return $this->render('articles/new.html.twig', array('form' => $form->createView()
            ));
        }

    /**
     * @Route("/article/edit/{id}" , name="edit_article", methods={"GET","POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array('attr' =>
                array('class' => 'form-control')))

            ->add('body', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')))

            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')))

            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('articles/edit.html.twig', array('form' => $form->createView()
        ));
    }

    /**
     * @Route("/article/{id}", name="article_show")
     * @param $id
     * @return Response
     */
        public function show($id)
        {
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

            return $this->render('articles/show.html.twig', array('article' => $article));
        }

    /**
     * @Route("/article/delete/{id}", methods={"DELETE"})
     * @param $id
     */
        public function delete($id)
        {
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();

            $response = new Response();
            $response->send();
        }

//
//    /**
//     * @Route("/article/save")
//     */
//    public function save()
//    {
//        /**
//         * dont do this in live version
//         * this is just for now
//         * there should not be a get function for entity's when doing things with the database
//         */
//
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $article = new Article();
//        $article->setTitle('Article 2');
//        $article->setBody('This is the body for article two');
//
//        $entityManager->persist($article);
//
//        $entityManager->flush();
//
//        return new Response('Saves an article with the id of'.$article->getId());
//    }


    }