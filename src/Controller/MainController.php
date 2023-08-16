<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function index()
{
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_login');
    }
    return $this->render('base.html.twig');
}
}