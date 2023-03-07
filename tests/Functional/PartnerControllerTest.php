<?php

namespace App\Tests\Functional;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PartnerControllerTest extends WebTestCase
{

  public function testUnauthorizedAccess()
  {
    $client = static::createClient();
    $client->request('GET', '/structure');

    $this->assertResponseRedirects('/');
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

  public function testStructurePageLogin(): void
  {
    $client = $this->getLoginClient('admin@todayfit.fr');
    $client->request('GET', '/structure');

    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
  }

  public function testLoggedStructurePageSeoTags(): void
  {
    $client = $this->getLoginClient('admin@todayfit.fr');
    $client->request('GET', '/structure');

    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('h1', 'Structures');
    $this->assertSelectorTextContains('h2', 'MES CLUBS');
  }

  public function testAdminLoggedMonStructure(): void
  {
    $client = $this->getLoginClient('admin@todayfit.fr');
    $client->request('GET', '/structure/monstructure');

    $this->assertResponseRedirects('/');
  }

  public function testLoggedStructureUserPageSeoTags(): void
  {
    $client = $this->getLoginClient('lille@todayfit.fr');
    $client->request('GET', '/structure/monstructure');

    $this->assertResponseIsSuccessful();
    // $this->assertSelectorTextContains('h1', 'Structures');
    // $this->assertSelectorTextContains('h2', 'MES CLUBS');
  }

  public function testLoggedFranchiseNotAuthUser(): void
  {
    $client = $this->getLoginClient('nord-est@todayfit.fr');
    $client->request('GET', '/structure/monstructure');

    $this->assertResponseIsSuccessful();
    // $this->assertSelectorTextContains('h1', 'Structures');
    // $this->assertSelectorTextContains('h2', 'MES CLUBS');
  }

}