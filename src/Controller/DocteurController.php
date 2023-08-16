<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Entity\User;
use App\Form\DocteurType;
use App\Repository\DocteurRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/docteur')]
class DocteurController extends AbstractController
{
    #[Route('/', name: 'app_docteur_index', methods: ['GET'])]
    public function index(DocteurRepository $docteurRepository): Response
    {
        return $this->render('docteur/index.html.twig', [
            'docteurs' => $docteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_docteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocteurRepository $docteurRepository, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $docteur = new Docteur();
        $user = new User();
        $form = $this->createForm(DocteurType::class, $docteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Create a new User entity
            $user->setUsername($form->get('user')->get('username')->getData());
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('user')->get('password')->getData());
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_DOCTOR']);

            // Establish the relationship
            $docteur->setUser($user);
            $user->setDocteur($docteur);


            // Persist the entities and flush the changes to the database
            $docteurRepository->save($docteur, true);
            $userRepository->save($user, true);


            return $this->redirectToRoute('app_docteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('docteur/new.html.twig', [
            'docteur' => $docteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_docteur_show', methods: ['GET'])]
    public function show(Docteur $docteur): Response
    {
        return $this->render('docteur/show.html.twig', [
            'docteur' => $docteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_docteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Docteur $docteur, DocteurRepository $docteurRepository, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(DocteurType::class, $docteur);
        $form->handleRequest($request);

        $user = $docteur->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $docteurRepository->save($docteur, true);

            if ($user) {
                $user->setUsername($form->get('user')->get('username')->getData());

                $plainPassword = $form->get('user')->get('password')->getData();
                if ($plainPassword) {
                    $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                    $user->setPassword($hashedPassword);
                }
                $user->setRoles(['ROLE_DOCTOR']);

                // Establish the relationship
                $docteur->setUser($user);
                $user->setDocteur($docteur);

                // Persist the entities and flush the changes to the database
                $userRepository->save($user, true);
            }

            return $this->redirectToRoute('app_docteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('docteur/edit.html.twig', [
            'docteur' => $docteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_docteur_delete', methods: ['POST'])]
    public function delete(Request $request, Docteur $docteur, DocteurRepository $docteurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $docteur->getId(), $request->request->get('_token'))) {
            $docteurRepository->remove($docteur, true);
        }

        return $this->redirectToRoute('app_docteur_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/list-patients', name: 'app_list_patients_docteur', methods: ['GET'])]
    public function listPatients(DocteurRepository $docteurRepository, $id): Response
    {
        $doctor = $docteurRepository->find($id);
    
        if (!$doctor) {
            throw $this->createNotFoundException('Doctor not found');
        }
    
        $patients = $docteurRepository->findPatientsByDoctor($doctor);
   
        return $this->render('docteur/list_patients.html.twig', [
            'doctor' => $doctor,
            'patients' => $patients,
        ]);
    }

}
