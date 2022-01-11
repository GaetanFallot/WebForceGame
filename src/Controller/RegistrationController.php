<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use App\Service\Mailer;
<<<<<<< layla
=======
use DateTimeImmutable;
>>>>>>> Envoie mail de confirmation
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
<<<<<<< layla
    private $mailer;

    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;

    }
=======
    private Mailer $mailer;

    public function __construct(Mailer $mailer){
        $this->mailer = $mailer;
    }

>>>>>>> Envoie mail de confirmation
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        UserAuthenticatorInterface $userAuthenticator, 
        AppAuthenticator $authenticator, 
        EntityManagerInterface $entityManager
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
<<<<<<< layla
            dd($hashedPassword);
            $user->setPassword($hashedPassword);
=======
            $user->setUserToken($this->generateToken());


>>>>>>> Envoie mail de confirmation
=======

            $user->setPassword($hashedPassword);
            $user->setUserToken($this->generateToken());
>>>>>>> Envoie mail de confirmation
            $entityManager->persist($user);

            $entityManager->flush();
            $this->addFlash('success', 'Inscription réussie');

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
            $this->mailer->sendEmail($user->getEmail(), $user->getUserToken());

            $this->mailer->sendEmail($user->getEmail(), $user->getUserToken());
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
<<<<<<< layla
    #[Route('/confirmAccount/{token}', name: 'confirm_account')]
    public function confirmAccount(string $token) {
        return $this->json($token);

    }

    private function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/-', '-_'), '=');
=======
    #[Route('/confirmer-mon-compte/{token}', name: 'confirm_account')]
    public function confirmAccount(string $token): JsonResponse
    {
        return $this->json($token);
    }

    /**
     * @throws \Exception
     */
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-'), '=');
>>>>>>> Envoie mail de confirmation
    }
}
