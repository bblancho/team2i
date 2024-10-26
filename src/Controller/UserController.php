<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserType;
use App\Entity\Clients;
use App\Form\ClientType;
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


class UserController extends AbstractController
{
    /**
     * This controller allow us to edit user profile
     *
     * @param Clients $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(
        Clients $user,
        Request $request,
        EntityManagerInterface $manager,
    ): Response {

        if( !$this->getUser() ){
            return $this->redirectToRoute('security.login');
        }
        
        if( $this->getUser() !== $user ){
            return $this->redirectToRoute('app_index');
        }

        $form = $this->createForm(ClientType::class, $user) ;
        
        $form->handleRequest($request) ;

        $user = $this->getUser() ;

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData() ;
            $manager->flush() ;

            $this->addFlash(
                'success',
                'Les informations de votre compte ont bien été modifiées.'
            );

            return $this->redirectToRoute('user.mesCandidatures');
        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * This controller allow us to edit your password
     *
     * @param Users $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/utilisateur/edition-mot-de-passe/{id}', 'user.edit.password', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function editPassword(
        Users $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher
    ): Response {

        if( !$this->getUser() ){
            return $this->redirectToRoute('security.login');
        }

        if( $this->getUser() !== $user ){
            return $this->redirectToRoute('app_index');
        }

        $form = $this->createForm(UserPasswordType::class, $user);
        
        $form->handleRequest($request);
        dd($form->getData()) ;

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Clients $user */
            $user = $form->getData();
            
            // Retrieve the value from the extra field non-mapped !
            $newpass = $form->get("plainPassword")->getData();

            if ( $hasher->isPasswordValid( $user , $form->get('password')->getData()) ) {

                dd('good') ;
                $hasher = $hasher->hashPassword(
                    $user,
                    $newpass
                );

                $user->setPassword($hasher);

                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié.'
                );

                $manager->flush();

                return $this->redirectToRoute('user.mesCandidatures');
            } 

            dd('bad') ;

            $this->addFlash(
                'warning',
                'Le mot de passe renseigné est incorrect.'
            );

        }

        return $this->render('pages/user/edit-password.html.twig', [
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

    /**
     * This controller allow us to edit user's profile
     *
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/utilisateur/mes-candidatures', name: 'user.mesCandidatures', methods: ['GET'])]
    public function mesCandidatures(

    ): Response {

        return $this->render('pages/user/mes-candidatures.html.twig', [
            
        ]);
    }


}
