<?php

namespace App\Service;

class TokenGeneration {

  public function __construct() {
  }

  public static function generateToken(): string {

    return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
  }
}