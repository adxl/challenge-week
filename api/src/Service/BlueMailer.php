<?php

namespace App\Service;

use App\Entity\User;
use GuzzleHttp\Client;

class BlueMailer {

  public function __construct() {
  }

  public function sendEmail(User $to, int $template, array $params = []): void {

    $client = new Client();

    $headers = [
      'api-key' => $_ENV['MAILER_API'],
      'Content-Type' => 'application/json',
      'accept' => 'application/json'
    ];

    $body = json_encode([
      'to' =>
      array([
        'name' => $to->getFirstname() . ' ' . $to->getLastname(),
        'email' => $to->getEmail()
      ]),
      'templateId' => $template,
      'params' => $params
    ]);

    $response = $client->request('POST', 'https://api.sendinblue.com/v3/smtp/email', [
      'headers' => $headers,
      'body' => $body
    ]);
  }
}