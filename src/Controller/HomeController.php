<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index2(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return new Response("Bonjour mes étudiants");
    }
}
