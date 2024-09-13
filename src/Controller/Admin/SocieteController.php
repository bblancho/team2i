<?php

namespace App\Controller\Admin;

use App\Entity\Societes;
use App\Repository\SocietesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin/societes", 'admin.societes.')]
#[IsGranted('ROLE_ADMIN')]
class SocieteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index( SocietesRepository $societesRepository,
    PaginatorInterface $paginator,
    Request $request): Response
    {
        $societes =  $paginator->paginate(
            $societesRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/clients/societes/index.html.twig', [
            'societes' => $societes
        ]);
    }

    #[Route('/creation', name: 'create')]
    public function create(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/{id}/activer-client', name: 'activer')]
    public function activer(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/{id}/desactiver-client', name: 'desactiver')]
    public function deactiver(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    /**
     * This controller allows us to delete an ingredient
     *
     * @param EntityManagerInterface $manager
     * @param Societes $client
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/suppression',  name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['DELETE'] )]
    public function delete( Societes $societe,
        EntityManagerInterface $manager
    ): Response {
        $manager->remove($societe);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre client a été supprimé avec succès !'
        );

        return $this->redirectToRoute('admin.societes..index');
    }
}
