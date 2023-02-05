<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

abstract class AbstractTest extends ApiTestCase
{
  private ?string $token = null;

  public function setUp(): void
  {
    self::bootKernel();
  }

  protected function createClientWithCredentials($token = null): Client
  {
    $token = $token ?: $this->getToken();

    return static::createClient([], ['headers' => ['authorization' => 'Bearer ' . $token]]);
  }

  /**
   * Use other credentials if needed.
   */
  protected function getToken($body = []): string
  {
    if ($this->token) {
      return $this->token;
    }

    $response = static::createClient()->request('POST', '/auth', ['json' => $body] ?: [
      'json' => [
        'username' => 'admin@example.com',
        'password' => '$3cr3t',
      ],
    ]);

    $this->assertResponseIsSuccessful();
    $data = json_decode($response->getContent());
    $this->token = $data->token;

    return $data->token;
  }

  // remove token
  protected function removeToken(): void
  {
    $this->token = null;
  }
}