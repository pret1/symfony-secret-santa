<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
            ->from(new Address('skonau@scnsoft.com', 'Owner'))
            ->to('skonau@scnsoft.com')
            ->subject('Join to secret santa!')
            ->htmlTemplate('mailer/mailer.html.twig')
        ;

        $mailer->send($email);

        $this->addFlash('success', 'Email send');

        return $this->redirectToRoute('app_santa');
    }
}
