<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticleRepository $articleRepository): Response
    {

        return $this->render('default/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['created' => 'DESC'], 6),
        ]);
    }

    #[Route('/details/{id}', name: 'article_details', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('default/details.html.twig', [
            'article' => $article,
        ]);
    }
}
