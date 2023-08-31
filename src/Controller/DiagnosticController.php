<?php

namespace App\Controller;

use App\Entity\Diagnostic;
use App\Entity\HistoriqueDiagnostic;
use App\Form\DiagnosticType;
use App\Repository\DiagnosticRepository;
use App\Repository\HistoriqueDiagnosticRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/diagnostic')]
class DiagnosticController extends AbstractController
{
    #[Route('/', name: 'app_diagnostic_index', methods: ['GET'])]
    public function index(DiagnosticRepository $diagnosticRepository): Response
    {
        return $this->render('diagnostic/index.html.twig', [
            'diagnostics' => $diagnosticRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_diagnostic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DiagnosticRepository $diagnosticRepository): Response
    {
        $diagnostic = new Diagnostic();
        $form = $this->createForm(DiagnosticType::class, $diagnostic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diagnostic->setDateCreaction(new \DateTime());

            $diagnosticRepository->save($diagnostic, true);

            return $this->redirectToRoute('app_diagnostic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diagnostic/new.html.twig', [
            'diagnostic' => $diagnostic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diagnostic_show', methods: ['GET'])]
    public function show(Diagnostic $diagnostic): Response
    {
        return $this->render('diagnostic/show.html.twig', [
            'diagnostic' => $diagnostic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_diagnostic_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Diagnostic $diagnostic, DiagnosticRepository $diagnosticRepository, HistoriqueDiagnosticRepository $historiqueDiagnosticRepository): Response
    {
        // Preserve old value
        $oldDiagnostic = clone $diagnostic;

        $form = $this->createForm(DiagnosticType::class, $diagnostic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Create a new HistoriqueDiagnostic entity
            $historiqueDiagnostic = new HistoriqueDiagnostic();
            $historiqueDiagnostic->setDiagnostic($diagnostic);
            $historiqueDiagnostic->setDateEdit(new \DateTime());
            $historiqueDiagnostic->setMaladie($oldDiagnostic->getMaladie());
            $historiqueDiagnostic->setDescription($oldDiagnostic->getDescription());
            $historiqueDiagnostic->setPrescription($oldDiagnostic->getPrescription());
            $historiqueDiagnostic->setEtat($oldDiagnostic->getEtat());

            // Save the new HistoriqueDiagnostic entity
            $historiqueDiagnosticRepository->save($historiqueDiagnostic, true);

            // Update and save the edited Diagnostic entity
            $diagnosticRepository->save($diagnostic, true);

            // Handle flash message and redirection
            $this->addFlash('success', 'Diagnostic updated successfully.');
            return $this->redirectToRoute('app_diagnostic_edit', ['id' => $diagnostic->getId()]);
        }

        return $this->renderForm('diagnostic/edit.html.twig', [
            'diagnostic' => $diagnostic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diagnostic_delete', methods: ['POST'])]
    public function delete(Request $request, Diagnostic $diagnostic, DiagnosticRepository $diagnosticRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diagnostic->getId(), $request->request->get('_token'))) {
            $diagnosticRepository->remove($diagnostic, true);
        }

        return $this->redirectToRoute('app_diagnostic_index', [], Response::HTTP_SEE_OTHER);
    }
}
