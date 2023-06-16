<?php

namespace App\Controller;

use App\Entity\Responsable;
use App\Entity\User;
use App\Form\ResponsableType;
use App\Repository\ResponsableRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/responsable')]
class ResponsableController extends AbstractController
{
    //
    #[Route('/', name: 'app_responsable_index', methods: ['GET'])]
    public function index(ResponsableRepository $responsableRepository): Response
    {
        return $this->render('responsable/index.html.twig', [
            'responsables' => $responsableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_responsable_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ResponsableRepository $responsableRepository, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $responsable = new Responsable();
        $user = new User();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Create a new User entity
            $user->setUsername($form->get('user')->get('username')->getData());
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('user')->get('password')->getData());
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_RESPONSABLE']);

            // Establish the relationship
            $responsable->setUser($user);
            $user->setResponsable($responsable);


            // Persist the entities and flush the changes to the database
            $responsableRepository->save($responsable, true);
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('responsable/new.html.twig', [
            'responsable' => $responsable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_responsable_show', methods: ['GET'])]
    public function show(Responsable $responsable): Response
    {
        return $this->render('responsable/show.html.twig', [
            'responsable' => $responsable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_responsable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Responsable $responsable, ResponsableRepository $responsableRepository, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        $user = $responsable->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $responsableRepository->save($responsable, true);

            if ($user) {
                $user->setUsername($form->get('user')->get('username')->getData());

                $plainPassword = $form->get('user')->get('password')->getData();
                if ($plainPassword) {
                    $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                    $user->setPassword($hashedPassword);
                }
                $user->setRoles(['ROLE_RESPONSABLE']);

                // Establish the relationship
                $responsable->setUser($user);
                $user->setResponsable($responsable);

                // Persist the entities and flush the changes to the database
                $userRepository->save($user, true);
            }

            return $this->redirectToRoute('app_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('responsable/edit.html.twig', [
            'responsable' => $responsable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_responsable_delete', methods: ['POST'])]
    public function delete(Request $request, Responsable $responsable, ResponsableRepository $responsableRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$responsable->getId(), $request->request->get('_token'))) {
            $responsableRepository->remove($responsable, true);
        }

        return $this->redirectToRoute('app_responsable_index', [], Response::HTTP_SEE_OTHER);
    }
}
