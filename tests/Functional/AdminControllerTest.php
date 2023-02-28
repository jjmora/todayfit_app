<?php

namespace App\Tests\Functional;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends WebTestCase
{

  public function testUnauthorizedAccess()
  {
    $client = static::createClient();
    $client->request('GET', '/admin');

    $this->assertResponseRedirects('/login');
  }

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

  public function testAdminPageLogin(): void
  {
    $client = $this->getLoginClient('admin@todayfit.fr');
    $client->request('GET', '/admin');

    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
  }

  public function testLoggedAdminPageSeoTags(): void
  {
    $client = $this->getLoginClient('admin@todayfit.fr');
    $client->request('GET', '/admin');

    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('h1', 'Admin Dashboard');
    $this->assertSelectorTextContains('p', 'Bonjour admin@todayfit.fr');
  }

}
