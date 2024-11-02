<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Entity\Candidatures;
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
    #[Route('/', name: 'app_index', methods: ['GET'])]
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
     * @param OffresRepository $offresRepository
     * @return Response
     */
    #[Route('/{slug}-{id}', name: 'app_show', methods: ['GET'], requirements: ['id' => '\d+' , 'slug' => '[a-z0-9-]+'] )]
    public function show(
        OffresRepository $offresRepository, int $id, string $slug
    ): Response {

        $mission = $offresRepository->find($id);

        if( $mission->getSlug() != $slug){
            return $this->redirectToRoute('offre.show', ['slug' => $mission->getSlug() , 'id' => $mission->getId()]) ;
        }

        return $this->render('pages/missions/show.html.twig', [
            'mission' => $mission
        ]);
    }

    /**
     * This controller allow us to see a recipe if this one is public
     *
     * @param OffresRepository $offresRepository
     * @return Response
     */
    #[Route('/{slug}-{id}/postuler', name: 'app_postuler', methods: ['GET'], requirements: ['id' => '\d+' , 'slug' => '[a-z0-9-]+'] )]
    public function postuler(
        OffresRepository $offresRepository, 
        int $id, 
        string $slug ,
        EntityManagerInterface $manager
    ): Response {

        $mission = $offresRepository->find($id);

        if( $mission->getSlug() != $slug){
            return $this->redirectToRoute('offre.show', ['slug' => $mission->getSlug() , 'id' => $mission->getId()]) ;
        }

        $freeLance = $this->getUser() ;

        $candidature = new Candidatures() ;

        $candidature->setOffres($mission)
            ->setClients($freeLance)
            ->setConsulte(false)
            ->setCreatedAt(new \DateTimeImmutable())
        ;

        $manager->persist($candidature);
        $manager->flush();

        $this->addFlash(
            'success',
            'Merci pour votre candidature.'
        );

        return $this->redirectToRoute('app_index');
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
