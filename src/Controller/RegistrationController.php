<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserToken;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use App\Service\NotifyService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{


    }
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        UserAuthenticatorInterface $userAuthenticator, 
        AppAuthenticator $authenticator, 
        EntityManagerInterface $entityManager,
        NotifyService $notifyService
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new DatetimeImmutable);
            // encode the plain password
            $hashedPassword = $userPasswordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );
<<<<<<< layla
            dd($hashedPassword);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);

            $entityManager->flush();

<<<<<<< layla
=======
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('eniscigtest@gmail.com', 'Staff'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
>>>>>>> *
            // do anything else you need here, like send an email
            $email = (new TemplatedEmail())
                ->from('eniscigtest@gmail.com')
                ->to($user->getEmail())
                ->subject("Validez votre compte")
                ->htmlTemplate('emails/registration_verification.html.twig')
                ->context([
                    'user' => $user,
                    'link' => $this->generateUrl(
                        'register_verification_email',
                        ['token' => $userToken->getToken()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ),
                ]);
            $notifyService->sendEmail($email);

            return $this->redirectToRoute('register_confirmation');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inscription/confirmation', name: 'register_confirmation')]
    public function registerConfirmation(): Response
    {
        return $this->render('registration/confirmation.html.twig');
    }

    #[Route('/inscription/verification-email/{token}', name: 'register_verification_email')]
    public function registerVerificationEmail(
        ?UserToken $userToken,
        EntityManagerInterface $entityManager,
        UserAuthenticatorInterface $userAuthenticator,
        AppAuthenticator $authenticator,
        Request $request
    ): Response
    {
        if ($userToken && $userToken->isValid()) {
            $userToken->setUsedAt(new DateTimeImmutable());
            $user = $userToken->getUser();
            $user->setStatus(User::STATUS_ACTIVE);

            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        $this->addFlash('danger', "Token invalide, Veuillez recréer un compte.");
        return $this->redirectToRoute('app_register');
    }
}