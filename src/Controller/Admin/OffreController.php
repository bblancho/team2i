<?php

namespace App\Controller\Admin;

use App\Entity\Offres;
use App\Form\OffreType;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route("/admin/offres", 'admin.offres.')]
class OffreController extends AbstractController
{   
    /**
     * This controller display all ingredients
     *
     * @param OffresRepository $offresRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'index', methods: ['GET'])]
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

        return $this->render('admin/missions/index.html.twig', [
            'missions' => $missions
        ]);
    }

    /**
     * This controller allow us to edit an ingredient
     *
     * @param Offres $offre
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    ##[Security("is_granted('ROLE_USER') and user === ingredient.getUser()")]
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edition', 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(
        Offres $offre,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {
            $offre = $form->getData();

            $manager->persist($offre);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre mission a été modifiée avec succès !'
            );

            return $this->redirectToRoute('admin.offres.index');
        }

        return $this->render('admin/missions/edit.html.twig', [
            'form' => $form->createView()
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
    #[Route('/creation', name: 'create', methods: ['GET', 'POST'] )]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $offre = new Offres();

        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $offre->setSlug($form["nom"]->getData());
            $offre->setSocietes($this->getUser());

            $manager->persist($offre);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre mission a été créé avec succès !'
            );

            return $this->redirectToRoute('admin.offres.index');
        }

        return $this->render('admin/missions/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allows us to delete an ingredient
     *
     * @param EntityManagerInterface $manager
     * @param Offres $offre
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/activer',  name: 'activer', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    // #[Security("is_granted('ROLE_USER') and user === ingredient.getUser()")]
    public function activer(
        EntityManagerInterface $manager,
        Offres $offre
    ): Response {   

        $this->addFlash(
            'success',
            'Votre mission a été publiée avec succès !'
        );

    
        return $this->redirectToRoute('admin.offres.index');
    }

    /**
     * This controller allows us to delete an ingredient
     *
     * @param EntityManagerInterface $manager
     * @param Offres $mission
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/desactiver',  name: 'desactiver', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    // #[Security("is_granted('ROLE_USER') and user === ingredient.getUser()")]
    public function desactiver(
        EntityManagerInterface $manager,
        Offres $offre
    ): Response {
        $manager->remove($offre);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre mission a été désactivée avec succès !'
        );

        return $this->redirectToRoute('admin.offres.index');
    }

    /**
     * This controller allows us to delete an ingredient
     *
     * @param EntityManagerInterface $manager
     * @param Offres $offre
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/suppression',  name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    // #[Security("is_granted('ROLE_USER') and user === ingredient.getUser()")]
    public function delete(
        EntityManagerInterface $manager,
        Offres $offre
    ): Response {
        $manager->remove($offre);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre mission a été supprimée avec succès !'
        );

        return $this->redirectToRoute('admin.offres.index');
    }

    

}
