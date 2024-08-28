<?php

namespace App\Repository;

use App\Entity\OrderMaterial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderMaterial>
 *
 * @method OrderMaterial|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderMaterial|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderMaterial[]    findAll()
 * @method OrderMaterial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderMaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderMaterial::class);
    }

//    /**
//     * @return OrderMaterial[] Returns an array of OrderMaterial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderMaterial
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
