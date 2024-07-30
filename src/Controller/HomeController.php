<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('pages/mentions.html.twig', [
            
        ]);
    }

    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('pages/a-propos.html.twig', [
            
        ]);
    }
}
