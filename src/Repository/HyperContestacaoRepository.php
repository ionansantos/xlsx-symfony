<?php

namespace App\Repository;

use App\Entity\HyperContestacao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HyperContestacao>
 *
 * @method HyperContestacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method HyperContestacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method HyperContestacao[]    findAll()
 * @method HyperContestacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HyperContestacaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HyperContestacao::class);
    }

//    /**
//     * @return HyperContestacao[] Returns an array of HyperContestacao objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HyperContestacao
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
