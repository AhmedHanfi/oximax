<?php

namespace App\Controller;

use App\Entity\Acceuil;
use App\Entity\User;
use App\Form\AcceuilType;
use App\Repository\AcceuilRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/acceuil')]
class AcceuilController extends AbstractController
{
    #[Route('/', name: 'app_acceuil_index', methods: ['GET'])]
    public function index(AcceuilRepository $acceuilRepository): Response
    {
        return $this->render('acceuil/index.html.twig', [
            'acceuils' => $acceuilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_acceuil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AcceuilRepository $acceuilRepository, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        $acceuil = new Acceuil();
        $user = new User();
        $form = $this->createForm(AcceuilType::class, $acceuil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Create a new User entity
            $user->setUsername($form->get('user')->get('username')->getData());
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('user')->get('password')->getData());
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_ACCEUIL']);

            // Establish the relationship
            $acceuil->setUser($user);
            $user->setAcceuil($acceuil);

            $userRepository->save($user, true);
            $acceuilRepository->save($acceuil, true);

            return $this->redirectToRoute('app_acceuil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('acceuil/new.html.twig', [
            'acceuil' => $acceuil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acceuil_show', methods: ['GET'])]
    public function show(Acceuil $acceuil): Response
    {
        return $this->render('acceuil/show.html.twig', [
            'acceuil' => $acceuil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_acceuil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Acceuil $acceuil, AcceuilRepository $acceuilRepository): Response
    {
        $form = $this->createForm(AcceuilType::class, $acceuil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $acceuilRepository->save($acceuil, true);

            return $this->redirectToRoute('app_acceuil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('acceuil/edit.html.twig', [
            'acceuil' => $acceuil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acceuil_delete', methods: ['POST'])]
    public function delete(Request $request, Acceuil $acceuil, AcceuilRepository $acceuilRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acceuil->getId(), $request->request->get('_token'))) {
            $acceuilRepository->remove($acceuil, true);
        }

        return $this->redirectToRoute('app_acceuil_index', [], Response::HTTP_SEE_OTHER);
    }
}
