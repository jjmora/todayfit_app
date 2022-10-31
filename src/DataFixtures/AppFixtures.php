<?php

namespace App\DataFixtures;

use App\Entity\Franchise;
use App\Entity\Partner;
use App\Entity\Permission;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

  public function load(ObjectManager $manager): void
  {
    // < Data
    $adminPassword = '$2y$13$WODq3sjeP3sE.z9h530MD.85tyVnOdCLm.Lfg4YYiUzRrDJVaf72S';
    $password = '$2y$13$WODq3sjeP3sE.z9h530MD.85tyVnOdCLm.Lfg4YYiUzRrDJVaf72S';
    $usersFranchiseArray = [
      ["idf", "https://images.pexels.com/photos/4662356/pexels-photo-4662356.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Takimata at sed amet dolor ex ut diam consetetur. Vulputate dolore duo dolor sit sed gubergren nonumy eos at elitr labore no lorem dolores. Est dolore invidunt eos odio aliquyam invidunt. Rebum praesent lorem elit dolore at consetetur et dolor aliquyam cum ut ipsum ipsum lorem."],
      ["sud", "https://images.pexels.com/photos/2247179/pexels-photo-2247179.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Ut et vero nonumy aliquyam takimata et at kasd ipsum duis ipsum est accusam euismod. Et amet veniam dolore eirmod sit sea eos ex takimata vulputate congue magna stet erat velit sed diam. Nonumy dolor duis gubergren."],
      ["sud-est", "https://images.pexels.com/photos/1954524/pexels-photo-1954524.jpeg?cs=srgb&dl=pexels-william-choquette-1954524.jpg&fm=jpg", "Sadipscing exerci est imperdiet sit magna diam elitr iriure ea quis laoreet facilisis dolores et sed. Et ea tempor ea consetetur et tempor velit dolor tempor eu no takimata zzril aliquyam blandit. Dolore vel magna sea. Amet odio nonumy sea amet sed sed invidunt. Gubergren gubergren no duis eos enim et lorem erat duo sanctus dolore consetetur sadipscing consectetuer lorem."],
      ["sud-ouest", "https://images.pexels.com/photos/3838937/pexels-photo-3838937.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Suscipit sit sed tation sadipscing luptatum dolore ipsum qui. Dolores magna lorem sit consetetur dignissim accusam justo sanctus et molestie dignissim nisl ut rebum eu lorem voluptua mazim. Nulla et amet ea labore. Gubergren sea nisl hendrerit magna lorem voluptua option tempor consectetuer elitr volutpat tempor et sit."],
      ["nord", "https://images.pexels.com/photos/5128204/pexels-photo-5128204.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "At sed diam vero nonumy takimata accusam et zzril. Et tincidunt consetetur. At rebum magna sit magna. Labore lorem clita rebum lorem no et dolor ullamcorper diam ut praesent dignissim ea voluptua."],
      ["nord-est", "https://images.pexels.com/photos/703016/pexels-photo-703016.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Placerat duo dolor elitr nonumy est ullamcorper nulla dolor dolor augue sit sea duo ipsum sadipscing. Invidunt diam sed diam sanctus eirmod consequat magna est rebum stet accusam nonumy eu autem quis et. Sanctus est hendrerit in aliquyam ipsum. Et iriure vero ex sed. Duis nulla consequat."],
      ["nord-ouest", "https://images.pexels.com/photos/4164841/pexels-photo-4164841.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "At ea lorem ex nonumy takimata stet justo diam in nisl dolore in diam ullamcorper. Eos velit sit kasd et takimata erat et eum. No lorem ea. Lorem eum te. Et diam eirmod autem ea nibh. Takimata dolor et ipsum sed nonumy et erat dolores ad facilisis sea sanctus amet justo invidunt et. Takimata diam ad eos lorem elitr sanctus. Ut no ipsum tempor dolore."],
      ["centre", "https://images.pexels.com/photos/13460163/pexels-photo-13460163.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Est at ipsum nonumy aliquam elitr invidunt velit sit dolor eos hendrerit tempor facilisis kasd. Autem nonummy at et stet justo ipsum elitr. Eos labore eos ea amet sadipscing nostrud voluptua lorem eos est lorem eos in. Est aliquyam iriure labore liber lorem at augue dolor clita vero ut et invidunt sed ea tempor."]
    ];
    $usersPartnerArray = [
      [   // $usersPartnerArray[$i]
        "idf",  //// $usersPartnerArray[$i][0]
        [ //// $usersPartnerArray[$i][1]
          [    //// $usersPartnerArray[$i][1][0]
            "Créteil", //// $usersPartnerArray[$i][1][0][0]
            "https://images.pexels.com/photos/3768730/pexels-photo-3768730.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", //// [$i][1][0][1]
            "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata. "
          ],
          [
            "Rueil", "https://images.pexels.com/photos/3253501/pexels-photo-3253501.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata. "
          ],
          [
            "Paris-Rivoli", "https://images.pexels.com/photos/1263349/pexels-photo-1263349.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata. "
          ],
          [
            "Paris-Gare-du-Nord", "https://images.pexels.com/photos/4662356/pexels-photo-4662356.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata. "
          ]
        ] 
      ],
      [
        "sud", 
        [
          ["Carcassone", "https://images.pexels.com/photos/2247179/pexels-photo-2247179.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Montpellier", "https://images.pexels.com/photos/7174396/pexels-photo-7174396.jpeg?auto=compress&cs=tinysrgb&w=600", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."]
        ] 
      ],
      [
        "sud-est", 
        [
          ["Arles", "https://images.pexels.com/photos/1954524/pexels-photo-1954524.jpeg?cs=srgb&dl=pexels-william-choquette-1954524.jpg&fm=jpg", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Avignon", "https://images.pexels.com/photos/6739958/pexels-photo-6739958.jpeg?auto=compress&cs=tinysrgb&w=600", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata." ],
          ["Marseille", "https://images.pexels.com/photos/7061661/pexels-photo-7061661.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."]
        ] 
      ],
      [
        "sud-ouest",
        [
          ["Bayonne", "https://images.pexels.com/photos/3838937/pexels-photo-3838937.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."]
        ] 
      ],
      [
        "nord", 
        [
          ["Rouen", "https://images.pexels.com/photos/5128204/pexels-photo-5128204.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Chartres", "https://images.pexels.com/photos/7672101/pexels-photo-7672101.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Le-Havre","https://images.pexels.com/photos/3836878/pexels-photo-3836878.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."]
        ] 
      ],
      [
        "nord-est", 
        [
          ["Verdun", "https://images.pexels.com/photos/703016/pexels-photo-703016.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Lille","https://images.pexels.com/photos/4162595/pexels-photo-4162595.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Dunkerque", "https://images.pexels.com/photos/4720796/pexels-photo-4720796.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["St-Quentin","https://images.pexels.com/photos/6388454/pexels-photo-6388454.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."]
        ] 
      ],
      [
        "nord-ouest", 
        [
          ["Brest", "https://images.pexels.com/photos/4164841/pexels-photo-4164841.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Quimper", "https://images.pexels.com/photos/416717/pexels-photo-416717.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Lorient","https://images.pexels.com/photos/4720574/pexels-photo-4720574.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."]
        ] 
      ],
      [
        "centre", 
        [
          ["Bourges","https://images.pexels.com/photos/13460163/pexels-photo-13460163.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Limoges", "https://images.pexels.com/photos/1111304/pexels-photo-1111304.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
          ["Tours", "https://images.pexels.com/photos/4853715/pexels-photo-4853715.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1", "Lorem ipsum dolor sit amet ipsum sanctus at clita. Ea vel dolores voluptua erat labore invidunt. Vulputate dolores dolor feugiat duo kasd kasd iriure et. Erat vero eum ut tempor et praesent feugait erat nibh diam ut ipsum luptatum ut takimata."],
        ] 
      ]
    ];
    $addresses = [
      ["place", "rue", "rue", "boulevard", "avenue"],
      [
        "Maurice-Charretier",
        "Pierre Motte",
        "des Dunes",
        "Michel Ange",
        "Lenotre",
        "de l'Amandier",
        "des Bateliers",
        "de la Mare aux Carats",
        "du Faubourg National",
        "Clement Marot",
        "de la Hulotais",
        "Michel Ange",
        "Frédéric Chopin",
        "de la Madeleine",
        "de Penthièvre",
        "du Paillle en queue",
        "de la Mare aux Carats",
        "du Lavarin Sud",
        "Petite Fusterie",
        "du Limas",
        "Albin Durand",
        "Jean Portalis"
      ]
    ];

    $permissionsArray = [
      ["Salle de Sport", "https://www.svgrepo.com/show/256525/running-fitness.svg"], 
      ["Virtual Biking", "https://cdn-icons-png.flaticon.com/512/71/71422.png"],
      ["Crossfit", "https://cdn-icons-png.flaticon.com/512/950/950472.png"],
      ["Virtual Boxing", "https://cdn-icons-png.flaticon.com/512/73/73029.png"],
      ["Piscine", "https://www.svgrepo.com/show/393385/swimming.svg"],
      ["Spa", "https://www.svgrepo.com/show/342830/spa.svg"],
      ["Yoga", "https://www.svgrepo.com/show/194923/yoga.svg"],
      ["Machine à Café", "https://www.svgrepo.com/show/142204/hot-drink.svg"],
      ["Newsletter", "https://cdn-icons-png.flaticon.com/512/2530/2530528.png"],
    ];
    $names = [
      ["Gabriel","Martin"],
      ["Léo","Bernard"],
      ["Raphaël","Thomas"],
      ["Louis","Petit"],
      ["Arthur","Robert"],
      ["Jules","Richard"],
      ["Adam","Durand"],
      ["Lucas","Dubois"],
      ["Hugo","Moreau"],
      ["Gabin","Laurent"],
      ["Léon","Simon"],
      ["Noé","Michel"],
      ["Paul","Lefebvre"],
      ["Nathan","Leroy"],
      ["Malo","Roux"],
      ["Marius","David"],
      ["Marceau","Bertrand"],
      ["Mathis","Morel"],
      ["Victor","Fournier"],
      ["Jade","Girard"],
      ["Louise","Bonnet"],
      ["Emma","Dupont"],
      ["Ambre","Lambert"],
      ["Alice","Fontaine"],
      ["Rose","Rousseau"],
      ["Anna","Vincent"],
      ["Lina","Muller"],
      ["Léna","Lefevre"],
      ["Chloé","Faure"],
      ["Julia","Andre"],
      ["Lou","Mercier"],
      ["Léa","Blanc"],
      ["Inès","Guerin"],
      ["Agathe","Boyer"],
      ["Iris","Garnier"],
      ["Zoé","Chevalier"],
      ["Eva","Francois"],
      ["Juliette","Legrand"],
      ["Léonie","Gauthier"],
      ["Jeanne","Garcia"],
      ["Zélie","Perrin"]
    ];
    $emailServer = [
      "fake.com", "yahoo.fr", "gmail.com", "protonmail.fr", "proton.me", "hotmail.fr", "hotmail.com", "aol.com", "outlook.com", "outlook.fr", "aim.com", "yahoo.com"
    ];
    // > Data

    // < Create User Admin
    $adminUser = new User();
    $adminUser->setEmail('admin@todayfit.fr')
      ->setRoles(["ROLE_ADMIN"])
      ->setPassword($adminPassword)
      ->setIsVerified(true)
      ->setPasswordReset(true)
      ;
    $manager->persist($adminUser);
    // > Create User Admin

    // < Create new Franchise Users & Franchises
    $allFranchiseUsers = [];
    $allFranchises = [];
    for ($i = 0; $i < count($usersFranchiseArray); $i++) {
      
      // < Create new Franchise Users

      $newUser = new User();
      $newUser->setEmail($usersFranchiseArray[$i][0].'@todayfit.fr')
        ->setRoles(["ROLE_FRANCHISE"])
        ->setPassword($password)
        ->setIsVerified(true)
        ->setPasswordReset(true)
        ;
      
      $manager->persist($newUser);
      $allFranchiseUsers[] = $newUser;
      // > Create new Franchise Users
    
      // < Create new Franchise
      $name = ucwords($usersFranchiseArray[$i][0]);
      $emailNameIndex = mt_rand(0, count($names) - 1);
      $lastName = mt_rand(0, count($names) - 1);
      $server = mt_rand(0, count($emailServer)-1);
      $emailString = str_replace(
        array('é','è','ë'),
        array('e','e','e'),
        strtolower($names[$emailNameIndex][0].'-'.$names[$lastName][0].'@'.$emailServer[$server])
      );
      

      
      // Find a randomDate between start_date 2010-01-01 and end_date 2022-10-31
      $randomDate = date("Y-m-d", mt_rand(1262347200,1667217600));
      $date = new DateTimeImmutable($randomDate." 12:00 Europe/London");
      $newDate = DateTime::createFromInterface($date);
          
      $newFranchise = new Franchise();
      $newFranchise->setName($name)
        ->setEmail($emailString)
        ->setActive(mt_rand(0,1))
        ->setUser($newUser)
        ->setImage($usersFranchiseArray[$i][1])
        ->setDescription($usersFranchiseArray[$i][2])
        ->setDate($newDate)
        ;
      $manager->persist($newFranchise);
      $allFranchises[] = $newFranchise;
      // < Create new Franchise
    }
    // < Create new Franchise Users & Franchises

    // < Create new Partner Users & Partners
    $allPartnerUsers = [];
    $allPartners = [];
    foreach($usersPartnerArray as $partners){
      // dump($partners); // all partners arrays with franch name
      // dump($partners[1]); // all partners arrays only partners array
      for($i = 0; $i < count($partners[1]); $i++){
        // < Create new Partner Users
        $name = mt_rand(0, count($names) - 1);
        $lastName = mt_rand(0, count($names) - 1);
        $server = mt_rand(0, count($emailServer)-1);

        $newUser = new User();
        $emailString = str_replace(
          array('é','è','ë'),
          array('e','e','e'),
          strtolower($partners[1][$i][0].'@todayfit.fr')
        );
        $newUser->setEmail($emailString)
          ->setRoles(["ROLE_PARTNER"])
          ->setPassword($password)
          ->setIsVerified(true)
          ->setPasswordReset(true)
        ;

        $manager->persist($newUser);
        $allPartnerUsers[] = $newUser;
        // > Create new Partner Users
                      
        // < Create new Partner  
        $newPartner = new Partner();
        $emailString = str_replace(
          array('é','è','ë'),
          array('e','e','e'),
          strtolower($names[$name][0].'-'.$names[$lastName][0].'@'.$emailServer[$server])
        );
        $addressString = mt_rand(1, 225).', '.$addresses[0][mt_rand(0, count($addresses[0])-1)].' '.$addresses[1][mt_rand(0, count($addresses[1])-1)];
        // Find a randomDate between start_date 2010-01-01 and end_date 2022-10-31
        $randomDate = date("Y-m-d", mt_rand(1262347200,1667217600));
        $date = new DateTimeImmutable($randomDate." 12:00 Europe/London");
        $newDate = DateTime::createFromInterface($date);
        
        for($k = 0; $k < count($usersPartnerArray); $k++){
          if($partners[0] == $usersPartnerArray[$k][0]){

            $newPartner->setName($partners[1][$i][0])
              ->setEmail($emailString)
              ->setAddress($addressString)
              ->setActive(mt_rand(0,1))
              ->setFranchise($allFranchises[$k])
              ->setUser($newUser)
              ->setImage($partners[1][$i][1])
              ->setDescription($partners[1][$i][2])
              ->setDate($newDate)
              ;
            $manager->persist($newPartner);

            $allPartners[] = $newPartner;
          }
        };
        // > Create new Partner
      }
    }
    // > Create new Partners Users & Partners

    // < Create permissions
    $allPermissions = [];
    for ($i = 0; $i < count($permissionsArray); $i++) {
      $newPermission = new Permission();
      $newPermission->setName($permissionsArray[$i][0])
        ->setImage($permissionsArray[$i][1])
      ;
      foreach($allFranchises as $franchise){
        $random = mt_rand(1,10);
        if($random < 6){
          $newPermission->addFranchise($franchise);
        }
      };
      foreach($allPartners as $partner){
        $random = mt_rand(1,10);
        if($random < 6){
          $newPermission->addPartner($partner);
        }
      };
      $allPermissions[] = $newPermission;
      $manager->persist($newPermission);
    }
    // > Create permissions


    // foreach($allPartners as $partner){
    //   dd($partner->getName());
    // }


    $manager->flush();
  }
}
