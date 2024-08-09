<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionType;
use App\Repository\MissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MissionController extends AbstractController
{   
        /**
     * This controller allow us to see a recipe if this one is public
     *
     * @param MissionsRepository $missionsRepository
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/mission/{id}', 'mission.show', methods: ['GET', 'POST'])]
    public function show(
        Missions $mission,
        Request $request,
        MissionsRepository $missionsRepository,
        EntityManagerInterface $manager
    ): Response {

        $mission =  $missionsRepository->findOneBy([
        'id' => $id,

        ]);

        return $this->render('pages/missions/show.html.twig', [
            'mission' => $mission
        ]);
    }

    /**
     * This controller display all ingredients
     *
     * @param MissionsRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/gestion/missions/user', name: 'mes_missions', methods: ['GET'])]
    public function my_mission(
        MissionsRepository $missionsRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        /** @var \App\Entity\Users $user */
        $user =  $this->getUser() ;
        $userId = $user->getId();

        $missions = $paginator->paginate(
            $user->getMissions(),
            $request->query->getInt('page', 1),
            10
        );

        // dd($user) ;

        // $products = $missionsRepository->findBy(
        //     ['users_id' => $userId],
        //     ['id' => 'DESC']
        // );

        return $this->render('pages/missions/mes_missions.html.twig', [
            "missions" => $missions
        ]);
    }

    /**
     * This controller show a form which create an mission
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/gestion/missions/creation', name: 'mission.new', methods: ['GET', 'POST'])]
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
            $mission->setSlug($form["nom"]->getData());

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

    /**
     * This controller allow us to edit an ingredient
     *
     * @param Missions $mission
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    ##[Security("is_granted('ROLE_USER') and user === ingredient.getUser()")]
    #[IsGranted('ROLE_USER')]
    #[Route('/gestion/mission/edition/{id}', 'mission.edit', methods: ['GET', 'POST'])]
    public function edit(
        Missions $mission,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission = $form->getData();

            $manager->persist($mission);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre mission a été modifiée avec succès !'
            );

            return $this->redirectToRoute('mes_missions');
        }

        return $this->render('pages/missions/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allows us to delete an ingredient
     *
     * @param EntityManagerInterface $manager
     * @param Missions $mission
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/gestion/mission/suppression/{id}', 'mission.delete', methods: ['GET'])]
    // #[Security("is_granted('ROLE_USER') and user === ingredient.getUser()")]
    public function delete(
        EntityManagerInterface $manager,
        Missions $mission
    ): Response {
        $manager->remove($mission);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre mission a été supprimée avec succès !'
        );

        return $this->redirectToRoute('mes_missions');
    }
}
