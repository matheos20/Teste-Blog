<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\AccountTypeEnum;
use App\Form\AuteurType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/auteur')]
class AuteurController extends AbstractController
{
    #[Route('/', name: 'auteur_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, AccountTypeEnum $accountTypeEnum): Response
    {
        return $this->render('auteur/index.html.twig', [
            'auteurs' => $userRepository->findBy(['type' => $accountTypeEnum->getAuteur()]),
        ]);
    }

    #[Route('/new', name: 'auteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $auteur = new User();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $auteur->setRoles([AccountTypeEnum::ROLE_AUTEUR]);
            $auteur->setType(AccountTypeEnum::AUTEUR);

            $auteur->setEmail('test@yopmail.com');
            $auteur->setPassword($passwordEncoder->encodePassword($auteur, $auteur->getFullname()));
            $entityManager->persist($auteur);
            $entityManager->flush();

            return $this->redirectToRoute('auteur_index');
        }

        return $this->render('auteur/new.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'auteur_show', methods: ['GET'])]
    public function show(User $auteur): Response
    {
        return $this->render('auteur/show.html.twig', [
            'auteur' => $auteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'auteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $auteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('auteur_index');
        }

        return $this->render('auteur/edit.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'auteur_delete', methods: ['POST'])]
    public function delete(Request $request, User $auteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$auteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($auteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('auteur_index');
    }
}
