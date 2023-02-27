<?php

namespace App\Tests\Functional;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function getLoginClient($userEmail)
    {
      $client = static::createClient();
      $userRepository = static::getContainer()->get(UserRepository::class);
      // retrieve the test user
      $testUser = $userRepository->findOneByEmail($userEmail);
      // simulate $testUser being logged in
      $client->loginUser($testUser);
      return $client;
    }

    public function testAdminLogin(): void
    {

      $client = $this->getLoginClient('admin@todayfit.fr');
      $client->request('GET', '/admin');
      $this->assertResponseIsSuccessful();
      $this->assertSelectorTextContains('p', 'Bonjour admin@todayfit.fr');

    }

    public function testFranchiseLogin(): void
    {

      $client = $this->getLoginClient('nord-est@todayfit.fr');
      $client->request('GET', '/franchise/mafranchise');
      $this->assertResponseIsSuccessful();
      $this->assertSelectorTextContains('h1', 'Nord-est');

    }

    public function testStructureLogin(): void
    {
      $client = $this->getLoginClient('lille@todayfit.fr');
      $client->request('GET', '/structure/monstructure');
      $this->assertResponseIsSuccessful();
      $this->assertSelectorTextContains('h1', 'Lille');

    }
}
