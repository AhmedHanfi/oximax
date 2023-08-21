<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Diagnostic;
use App\Entity\DocteurPatientLigne;
use App\Form\DiagnosticType;
use App\Form\PatientType;
use App\Repository\DiagnosticRepository;
use App\Repository\DocteurRepository;
use App\Repository\PatientRepository;
use App\Repository\DocteurPatientLigneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/patient')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'app_patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response
    {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PatientRepository $patientRepository, DocteurRepository $docteurRepository): Response
    {
        $patient = new Patient();
        $docteur = $docteurRepository->findAll();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patientRepository->save($patient, true);

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
            'docteurs' => $docteur,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager, PatientRepository $patientRepository, DocteurRepository $docteurRepository, DocteurPatientLigneRepository $reoLigDocpatient): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             //$doc = $docteurRepository->findOneBy(array('id'=>$form->get('docteurs')->getData()[0]->getId()));
             //$patient->addDocteurPatientLigne($doc);

            $ligDocpatient = $reoLigDocpatient->findBy([
                'Patient' => $patient,
            ]);

            foreach ($ligDocpatient as $docteurLigne) {
                $entityManager->remove($docteurLigne);
            }

            $entityManager->flush();

            $patientRepository->save($patient, true);
            $selectedDoctors = $request->get('doctorSelect', []);
            foreach($selectedDoctors as $doctorId){
                $doc = $docteurRepository->find($doctorId);
                $docLig = new DocteurPatientLigne();
                $docLig->setDocteur($doc);
                $docLig->setPatient($patient);
                $reoLigDocpatient->save($docLig);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/edit.html.twig', [
            'patient' => $patient,
            'docteurs' => $docteurRepository->findAll(),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, PatientRepository $patientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $patientRepository->remove($patient, true);
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{patientId}/add-diagnostic', name: 'app_add_diagnostic', methods: ['POST'])]
    public function addDiagnostic(Request $request, DiagnosticRepository $diagnosticRepository, PatientRepository $patientRepository, $patientId): Response
    {
        $patient = $patientRepository->find($patientId);

        if (!$patient) {
            throw $this->createNotFoundException('Patient not found');
        }

        $diagnostic = new Diagnostic();
        $diagnostic->setPatient($patient);

        $form = $this->createForm(DiagnosticType::class, $diagnostic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the diagnostic
            $diagnosticRepository->save($diagnostic, true);

            return $this->json(['message' => 'Diagnostic added successfully'], Response::HTTP_OK);
        }

        return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);

    }


}
