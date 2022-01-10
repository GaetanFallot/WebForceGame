<?php
namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer {
    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }
    public function sendEmail($email, $token) {
        $email = (new TemplatedEmail())
            ->from('eniscigtest@gmail.com')
            ->to(new Address($user->getEmail()))
            ->subject('Thanks for signing up!')

            // path of the Twig template to render
            ->htmlTemplate('emails/registration.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
            ]);
    }
}