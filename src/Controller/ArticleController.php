<?php

namespace App\Controller;

use App\Entity\Article;
use App\Enum\AccountTypeEnum;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articles')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request, EntityManagerInterface $entityManager): Response
    {
        $query = $articleRepository->findArticles($this->getUser());
        $page = $paginator->paginate($query, $request->query->getInt('page',1),5);

        return $this->render('article/index.html.twig', [
            'articles' => $page,
        ]);
    }

    #[Route('/new', name: 'article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article, [
            "type" => $currentUser->getType()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($currentUser->getType() == AccountTypeEnum::AUTEUR) {
                $article->setAuteur($currentUser);
            }
            $article->setCreated(new \DateTime());
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $form = $this->createForm(ArticleType::class, $article,  [
            "type" => $currentUser->getType()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdated(new \DateTime());
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
