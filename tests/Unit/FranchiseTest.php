<?php

namespace App\Tests\Unit;

use App\Entity\Franchise;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase; // let us use the validator

class FranchiseTest extends KernelTestCase
{
  public function getEntity(): Franchise
  {
    return (new Franchise())
      ->setName('abc')
      ->setImage('');
  }

  public function testEntityIsValid(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $permission = $this->getEntity();

    $errors = $container->get('validator')->validate($permission);

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
