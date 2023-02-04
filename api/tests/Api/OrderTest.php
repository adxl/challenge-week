<?php

namespace App\Tests\Api;

use App\Repository\UserRepository;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class OrderTest extends ApiTestCase
{

  public function testAdminResource()
  {
    $client = static::createClient();
    $userRepository = static::getContainer()->get(UserRepository::class);

    // retrieve the test user
    $testUser = $userRepository->findOneByEmail('client_1@esgi.fr');

    // simulate $testUser being logged in
    $client->loginUser($testUser);

    $response = $client->request('GET', '/users');
    $this->assertResponseIsSuccessful();
  }
}