<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function index(PatientRepository $patientRepository)
{
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_login');
    }

    $counts = $patientRepository->getTotalCounts();
    return $this->render('base.html.twig', [
        'counts' => $counts,
    ]);
}
}