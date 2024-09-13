<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Repository\OffresRepository;
use App\Repository\MissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

     /**
     * This controller display all ingredients
     *
     * @param OffresRepository $offresRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/missions', name: 'app_missions', methods: ['GET'])]
    public function index(
        OffresRepository $offresRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $missions =  $paginator->paginate(
            $offresRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/missions/index.html.twig', [
            'missions' => $missions
        ]);
    }

    
    /**
     * On va lister les missions d'une société
     *
     * @return Response
     */
    #[Route('/societe-{slug}', name: 'app_societe_offres', methods: ["GET"])]
    public function offresSociete(): Response
    {

        return $this->render('pages/missions/show.html.twig');
    }



}
