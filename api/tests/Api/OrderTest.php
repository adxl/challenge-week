<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Product;
use App\Tests\AbstractTest;

final class OrderTest extends AbstractTest
{

  public function testAdminResource()
  {
    $token = $this->getToken(['email' => 'client_1@esgi.fr', 'password' => 'esgi']);
    $response = $this->createClientWithCredentials($token)->request('GET', '/users');
    $this->assertResponseIsSuccessful();
  }

  public function testClientOrderAndDelivererValidateAndClientReview(): void
  {

    /* CLIENT */

    // login as client and get token
    $token = $this->getToken(['email' => 'client_1@esgi.fr', 'password' => 'esgi']);

    $client = $this->createClientWithCredentials($token);
    $response = $client->request('GET', '/users');
    $this->assertResponseIsSuccessful();

    // get random products
    $products = static::getContainer()->get('doctrine')->getRepository(Product::class)->findAll();
    $rand_products_keys = array_rand($products, 4);
    $rand_products = [];
    foreach ($rand_products_keys as $key) {
      $rand_products[] = [
        'quantity' => rand(1, 10),
        'id' => $products[$key]->getId(),
      ];
    }

    // create an order
    $response = ($client->request('POST', '/orders', [
      'json' => [
        'productsOrder' => $rand_products,
      ],
    ]));
    $order = (array) json_decode($response->getContent());

    $this->assertResponseStatusCodeSame(200);

    /* DELIVERER */

    // login as deliverer and get token
    $this->removeToken();
    $token = $this->getToken(['email' => 'deliverer_1@esgi.fr', 'password' => 'esgi']);

    $client = $this->createClientWithCredentials($token);
    $response = $client->request('GET', '/users');
    $this->assertResponseIsSuccessful();

    // get deliverer id
    $response = $client->request('GET', '/users/me');
    $deliverer = (array) json_decode($response->getContent());
    $this->assertResponseIsSuccessful();

    // take order
    $client->request('PATCH', '/orders/' . $order['orderId'], [
      'json' => [
        'status' => 'SHIPPING',
        'deliverer' => "/users/" . $deliverer['id'],
      ],
      "headers" => [
        "Content-Type" => "application/merge-patch+json"
      ],
    ]);
    $this->assertResponseIsSuccessful();

    // validate order
    $client->request('PATCH', '/orders/' . $order['orderId'], [
      'json' => [
        'status' => 'DONE',
      ],
      "headers" => [
        "Content-Type" => "application/merge-patch+json"
      ],
    ]);
    $this->assertResponseIsSuccessful();

    /* CLIENT */

    // login as client and get token
    $this->removeToken();
    $token = $this->getToken(['email' => 'client_1@esgi.fr', 'password' => 'esgi']);

    $client = $this->createClientWithCredentials($token);
    $response = $client->request('GET', '/users');
    $this->assertResponseIsSuccessful();

    // give a deliverer review
    $response = $client->request('POST', '/deliverer_reviews', [
      'json' => [
        'rating' => rand(1, 5),
        'comment' => 'test',
        'originOrder' => "/orders/" . $order['orderId'],
      ],
    ]);
    $this->assertResponseIsSuccessful();

    // get order
    $response = $client->request('GET', '/orders/' . $order['orderId']);
    $order = (array) json_decode($response->getContent());

    // give a review for each product
    foreach ($order['productReviews'] as $productReview) {
      $rand_rating = [true, false][rand(0, 1)];
      $client->request('PATCH', '/product_reviews/' . $productReview->id, [
        'json' => [
          'rating' => $rand_rating,
          'originOrder' => "/orders/" . $order['id'],
          'product' => ((array) $productReview->product)['@id'],
        ],
        "headers" => [
          "Content-Type" => "application/merge-patch+json"
        ],
      ]);
      $this->assertResponseIsSuccessful();
    }
  }
}