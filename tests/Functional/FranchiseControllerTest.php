<?php

namespace App\Tests\Functional;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FranchiseControllerTest extends WebTestCase
{

  public function testUnauthorizedAccess()
  {
    $client = static::createClient();
    $client->request('GET', '/franchise');

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

  public function testFranchisePageLogin(): void
  {
    $client = $this->getLoginClient('admin@todayfit.fr');
    $client->request('GET', '/admin');

    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
  }

  public function testLoggedFranchisePageSeoTags(): void
  {
    $client = $this->getLoginClient('admin@todayfit.fr');
    $client->request('GET', '/franchise');

    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('h1', 'Franchises');
    $this->assertSelectorTextContains('h2', 'MES CLUBS');
  }

  // public function testAdminLoggedMaFranchise(): void
  // {
  //   $client = $this->getLoginClient('admin@todayfit.fr');
  //   $client->request('GET', '/franchise/mafranchise');

  //   $this->assertResponseRedirects('/');
  // }

  // public function testAdminLoggedDeleteFranchise(): void
  // {
  //   $client = $this->getLoginClient('admin@todayfit.fr');
    
  //   // Register a new User
  //   // $client->request('GET', '/register');
  //   // $client->submitForm('register-user',[
  //   //     'registration_form[email]' => 'test@test.com',
  //   //     'registration_form[plainPassword]' => '$2y$13$WODq3sjeP3sE.z9h530MD.85tyVnOdCLm.Lfg4YYiUzRrDJVaf72S'
  //   // ]);
    
  //   $client->request('GET', 'franchise/show/10');
    
  //   $this->assertSelectorTextContains('h1', 'test1');
    
  //   //needs a new Franchise
  //   //$client->submitForm('btn-delete-franchise');
    
  //   $this->assertResponseIsSuccessful();
  //   // $this->assertResponseRedirects('/user');
  // }

}
