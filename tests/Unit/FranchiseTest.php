<?php

namespace App\Tests\Unit;

use App\Entity\Franchise;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FranchiseTest extends WebTestCase
{
  public function getEntity(): Franchise
  {
    $userRepository = static::getContainer()->get(UserRepository::class);
    $testUser = $userRepository->findOneByEmail('test@test.fr');

    return (new Franchise())
      ->setName('')
      ->setEmail('abc@email.com')
      ->setImage('')
      ->setDescription('Lorem ipsum')
      ->setUser($testUser)
      ;
  }

  public function testEntityIsValid(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $franchise = $this->getEntity();

    $errors = $container->get('validator')->validate($franchise);

    $this->assertCount(0, $errors);
  }

  // public function testUrlIsNotValid(): void
  // {
  //   $urlsArray = [
  //     'http//urlnotvalid',  //NOT VALID
  //     'https:/urlnotvalid', //NOT VALID
  //     'urlnotvalid'         //NOT VALID
  //   ];

  //   self::bootKernel();
  //   $container = static::getContainer();

  //   $permission = $this->getEntity();

  //   for ($i = 0; $i < count($urlsArray); $i++) {
  //     $permission->setImage($urlsArray[$i]);
  //     $errors = $container->get('validator')->validate($permission);
  //     $this->assertCount(1, $errors);
  //   }
  // }

  // public function testUrlIsValid(): void
  // {
  //   $urlsArray = [
  //     '',                   //VALID
  //     'http://urlIsvalid',  //VALID
  //   ];

  //   self::bootKernel();
  //   $container = static::getContainer();
  //   $permission = $this->getEntity();
  //   for ($i = 0; $i < count($urlsArray); $i++) {
  //     $permission->setImage($urlsArray[$i]);
  //     $errors = $container->get('validator')->validate($permission);
  //     $this->assertCount(0, $errors);
  //   }
  // }

}
