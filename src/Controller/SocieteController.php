<?php

namespace App\Controller;

use App\Entity\Societes;
use App\Form\SocieteType;
use App\Form\UserPasswordType;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SocieteController extends AbstractController
{
    
    /**
     * This controller allow us to edit user's profile
     *
     * @param Societes $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/societe/edition/{id}', name: 'societe.edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(
        Societes $user,
        Request $request,
        EntityManagerInterface $manager,
        UploaderHelper $helper
    ): Response {

        if( !$this->getUser() ){
            return $this->redirectToRoute('security.login');
        }
        
        if( $this->getUser() !== $user ){
            return $this->redirectToRoute('app_index');
        }

        $form = $this->createForm(SocieteType::class, $user);

        $cheminFichier  = $helper->asset($user, 'imageFile') ;

        $form->handleRequest($request);
        $user = $this->getUser() ;

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Societes $user */
            $user = $form->getData();
            $manager->flush();

            $this->addFlash(
                'success',
                'Les informations de votre compte ont bien été modifiées.'
            );

            return $this->redirectToRoute('offres.mes_offres', ['id' => $user->getId()]);
        }

        return $this->render('pages/societe/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * This controller allow us to edit user's profile
     *
     * @param Societes $societe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/societe/edition-mot-de-passe/{id}', 'societe.edit.password', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function editPassword(
        Societes $societe,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher
    ): Response {
        $form = $this->createForm(UserPasswordType::class, $societe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Societes $user */
            $user = $form->getData();

            // Retrieve the value from the extra field non-mapped !
            $newpass = $form->get("plainPassword")->getData();

            if ($hasher->isPasswordValid($societe, $form->get('password')->getData())) {

                $hasher = $hasher->hashPassword(
                    $societe,
                    $newpass
                );

                $societe->setPassword($hasher);

                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié.'
                );

                $manager->flush();
                dd('good');

                return $this->redirectToRoute('mes_mission');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
        }

        return $this->render('pages/societe/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller allow us to edit user's profile
     *
     * @param Users $choosenUser
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/candidature/offre-{id}-{slug}', name: 'user.candidature', methods: ['GET'], requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG])]
    public function candidature(
        OffresRepository $offresRepository, 
        int $id, 
        string $slug ,
        EntityManagerInterface $manager
    ): Response {
        
        $mission    = $offresRepository->find($id);
        $freeLance  = $this->getUser() ;

        if( $mission->getSlug() != $slug ){
            return $this->redirectToRoute('offre.show', ['slug' => $mission->getSlug() , 'id' => $mission->getId()]) ;
        }

        // On vérifie que le user n'ai pas déjà postulé
            // On fait la redirection sur la page show
        // On crée notre objet Candidature
        // On le sauvegarde
        // On fait la redirection sur la page show + message

        return $this->redirectToRoute('offre.show', ['slug' => $mission->getSlug() , 'id' => $mission->getId()]) ;
    }

}
