<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ServiceController extends AbstractController
{
    #[Route('/service/{n}', name: 'app_service')]
    public function showService($n): Response
    {
        return $this->render('service/showservice.html.twig', [
            'param1' => $n
        ]);
    }

    #[Route('/goto', name: 'app_goto')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute("app_home");
    }
}
