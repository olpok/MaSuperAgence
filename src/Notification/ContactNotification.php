<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

    class ContactNotification
    {
        /**
         * @var MailerInterface
         */
        private $mailer;

        /**
         * @var Environment
         */
        private $renderer;


        public function __construct(MailerInterface $mailer, Environment $renderer)
        {
        $this->mailer=$mailer;
        $this->renderer=$renderer;
        }
         
        public function notify(Contact $contact)
        {
            $email = (new TemplatedEmail())
                ->subject('Agence:' .$contact->getProperty()->getTitle())
                ->from('noreply@agence.fr') // ->setFrom($contact->getEmail())
                ->to($contact->getEmail())  
                ->text('Sending emails is fun again!')
               //  ->html('<h1>See Twig integration for better HTML integration!</h1>');
               // ->html(
               //     $this->renderer->render(
               //      'emails/contact.html.twig',
               //     ['contact' => $contact]
                //    )
              /// )               
                  ->htmlTemplate('emails/contact.html.twig')   
                  ->context([
                'contact' => $contact
                  ])  
            ;
            $this->mailer->send($email);          

        }

    }