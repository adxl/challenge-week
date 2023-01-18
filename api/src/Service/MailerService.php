<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;

class MailerService
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    private function sendTemplateEmail($to, $subject, $template, $context): bool
    {

        $email = (new TemplatedEmail())->from($_ENV["MAILER_FROM_ADDRESS"])
          ->to($to)
          ->subject($subject)
          ->htmlTemplate($template)
          ->context($context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }
        return true;
    }

    public function notifyCreatedAdmin(string $to, $name, $password): bool
    {
        $subject = "Bienvenue sur MySchool";
        $template = "mailing/admin_new_account.html.twig";
        $context = ['name' => $name, 'password' => $password];

        return $this->sendTemplateEmail($to, $subject, $template, $context);
    }

    public function sendVerificationEmail(string $to, $name, $url): bool
    {
        $subject = "Vérification de votre compte";
        $template = "verify_token.html.twig";
        $context = ['url_verify' => $url, "email_name" => $name];

        return $this->sendTemplateEmail($to, $subject, $template, $context);
    }
}