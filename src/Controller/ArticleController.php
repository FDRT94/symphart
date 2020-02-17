<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController

{
    /**
     * @Route("/", methods={"GET"})
     *
     */
    public function index()
    {
//        return new  Response('<html><body>hello</body></html>');

        return $this->render("articles/index.html.twig");
    }


}