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
     * This controller allow us to see a recipe if this one is public
     *
     * @param MissionsRepository $missionsRepository
     * @return Response
     */
    #[Route('/mission/{id}', name: 'mission.show', methods: ['GET'], requirements: ['id' =>Requirement::DIGITS])]
    public function show(
        Request $request,
        MissionsRepository $missionsRepository,
        EntityManagerInterface $manager
    ): Response {

        $mission =  $missionsRepository->findOneBy(['id' => $id]);

        return $this->render('pages/missions/show.html.twig', [
            'mission' => $mission
        ]);
    }

    

    /**
     * This controller allow us to see one mission if this one is public
     *
     * @return Response
     */
    #[Route('/missiontest', name: 'app_mission_show', methods: ["GET"])]
    public function showtest(): Response
    {
        // if ( !$mission ) {
        //     throw $this->createNotFoundException('Aucune mission trouvée.') ;
        // }

        return $this->render('pages/missions/show.html.twig');
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
