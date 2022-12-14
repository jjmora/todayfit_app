<?php

namespace App\Repository;

use App\Entity\Partner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Partner>
 *
 * @method Partner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partner[]    findAll()
 * @method Partner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partner::class);
    }

    public function search($input_data = null, $active = null)
    {
      $query = $this->createQueryBuilder('p');

      if($input_data != null){
        $query
          ->where('p.Name LIKE :input_data OR p.Email LIKE :input_data OR p.description LIKE :input_data OR p.Address LIKE :input_data')
          ->setParameter('input_data', '%'.$input_data.'%')
          ;
      }
      if($active != null){
        $query
          ->andWhere('p.Active = :active')
          ->setParameter('active', $active)
          ;
      }

      return $query->getQuery()->getResult();
    }

    public function searchByFranchise($franchise, $input_data = null, $active = null)
    {
      $query = $this->createQueryBuilder('p');
      $franchiseId = $franchise->getId();

      if($input_data != null){
        $query
          ->where('
            p.franchise = :franchise AND p.Name LIKE :input_data 
            OR p.franchise = :franchise AND p.Email LIKE :input_data 
            OR p.franchise = :franchise AND p.description LIKE :input_data 
            OR p.franchise = :franchise AND p.Address LIKE :input_data')
          ->setParameter('input_data', '%'.$input_data.'%')
          ->setParameter('franchise', $franchiseId)
          ;
      }

      if($active != null){
        $query
          ->andWhere('
            p.franchise = :franchise AND p.Active = :active'
            )
          ->setParameter('active', $active)
          ->setParameter('franchise', $franchiseId)
          ;
      }

      if($active == null){
        $query
          ->andWhere('p.franchise = :franchise')
          ->setParameter('franchise', $franchiseId)
          ;
      }

      return $query->getQuery()->getResult();
    }

    public function add(Partner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Partner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Partner[] Returns an array of Partner objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Partner
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
