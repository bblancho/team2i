<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\UserService;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public function __construct(private UserService $user)
    {
    }

    #[Route(path: '/connexion', name: 'security.login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->user->getUser()) {
            return $this->redirectToRoute('app_missions');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/deconnexion', name: 'security.logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * This controller allow us to register.
     */
    #[Route('/inscription', 'security.registration', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $user->setRoles(['ROLE_USER']);
        $user->setTypeUser('client');
        
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form["password"]->getData()
            );

            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été créé.'
            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute('security.login');
        }

        return $this->render('pages/register/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }


}
