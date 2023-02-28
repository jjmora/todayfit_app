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
      ->setName('abc')
      ->setEmail('abc@email.com')
      ->setImage('')
      ->setDescription('Lorem ipsum')
      ->setUser($testUser);
  }

  public function testEntityIsValid(): void
  {
    self::bootKernel();
    $container = static::getContainer();
    $franchise = $this->getEntity();

    $errors = $container->get('validator')->validate($franchise);

    $this->assertCount(0, $errors);
  }

  public function testEntityIsNotValidByBlankName(): void
  {
    self::bootKernel();
    $container = static::getContainer();
    $franchise = $this->getEntity();
    $franchise->setName('');

    $errors = $container->get('validator')->validate($franchise);

    $this->assertCount(2, $errors); // Not Blank + >3 characters
  }

  public function testEntityIsNotValidByShortName(): void
  {
    self::bootKernel();
    $container = static::getContainer();
    $franchise = $this->getEntity();
    $franchise->setName('ab');

    $errors = $container->get('validator')->validate($franchise);

    $this->assertCount(1, $errors); // >3 characters
  }

  public function testEntityIsNotValidByLongName(): void
  {
    self::bootKernel();
    $container = static::getContainer();
    $franchise = $this->getEntity();
    $franchise->setName('
      A esto dijo el ventero que se engañaba; que, puesto caso que en las historias no se escribía, por haberles parecido a los autores dellas que no era menester escrebir una cosa tan clara y tan necesaria de traerse como eran dineros y camisas limpias, no por eso se había de creer que no los trujeron; y así, tuviese por cierto y averiguado que todos los caballeros andantes, de que tantos libros están llenos y atestados, llevaban bien herradas las bolsas, por lo que pudiese sucederles; y que asimismo llevaban camisas y una arqueta pequeña llena de ungüentos para curar las heridas que recebían, porque no todas veces en los campos y desiertos donde se combatían y salían heridos había quien los curase, si ya no era que tenían algún sabio encantador por amigo, que luego los socorría, trayendo por el aire, en alguna nube, alguna doncella o enano con alguna redoma de agua de tal virtud que, en gustando alguna gota della, luego al punto quedaban sanos de sus llagas y heridas, como si mal alguno hubiesen tenido.
    ');

    $errors = $container->get('validator')->validate($franchise);

    $this->assertCount(1, $errors); // <50 characters
  }

  public function testEmailIsValid(): void
  {
    self::bootKernel();
    $container = static::getContainer();
    $franchise = $this->getEntity();
    $franchise->setEmail('email@todayfit.fr');

    $errors = $container->get('validator')->validate($franchise);

    $this->assertCount(0, $errors);
  }

  public function testEntityIsNotValidByBlankEmail(): void
  {
    self::bootKernel();
    $container = static::getContainer();
    $franchise = $this->getEntity();
    $franchise->setEmail('');

    $errors = $container->get('validator')->validate($franchise);

    $this->assertCount(1, $errors); // Not Blank 
  }

  public function testEntityIsNotValidByEmailFormat(): void
  {
    self::bootKernel();
    $container = static::getContainer();
    $franchise = $this->getEntity();
    
    $franchise->setEmail('email@ with spaces.com');
    $errors = $container->get('validator')->validate($franchise);
    $this->assertCount(1, $errors); // Not Blank 

    $franchise->setEmail('emailwithoutat.com');
    $errors = $container->get('validator')->validate($franchise);
    $this->assertCount(1, $errors); // Not Blank 
  }
}
