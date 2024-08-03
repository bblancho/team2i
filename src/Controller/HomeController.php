<?php

namespace App\Controller;

use App\Repository\MissionsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * This controller display all ingredients
     *
     * @param MissionsRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/missions', name: 'app_home', methods: ['GET'])]
    public function index(
        MissionsRepository $missionsRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $missions = $paginator->paginate(
            $missionsRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/missions/index.html.twig', [
            "missions" => $missions
        ]);
    }

    
    #[Route('/missions/show', name: 'app_mission_show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('pages/missions/show.html.twig', []);
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
