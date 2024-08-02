<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class MissionController extends AbstractController
{
    #[Route('/missions', name: 'app_mission', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/missions/index.html.twig', [
    
        ]);
    }

    /**
     * This controller show a form which create an mission
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/missions/creation',name: 'mission.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $mission = new Missions();

        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // dd($this->getUser());
            $mission->setUsers($this->getUser());
            $mission->setSlug($form["nom"]->getData()) ;

            $manager->persist($mission);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre mission a été créé avec succès !'
            );

            return $this->redirectToRoute('app_mission');
        }

        return $this->render('pages/missions/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/missions/show', name: 'app_mission_show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('pages/missions/show.html.twig', [
    
        ]);
    }
}
