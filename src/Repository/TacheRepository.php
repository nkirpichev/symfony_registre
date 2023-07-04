<?php

namespace App\Repository;

use App\Entity\Tache;
use App\Entity\TacheStatut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tache>
 *
 * @method Tache|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tache|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tache[]    findAll()
 * @method Tache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tache::class);
    }

    public function save(Tache $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tache $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLastByStatus($value): array
    {
 
     $conn = $this->getEntityManager()->getConnection();
 
     $sql = '
         SELECT t.* FROM tache_statut t
         where not exists( select 1 from tache_statut t2
                where t2.tache_id = t.tache_id and t2.date_changement>t.date_changement )
            and t.statut_id = :value 
         ';
     $stmt = $conn->prepare($sql);
     $resultSet = $stmt->executeQuery(['value' => $value]);

     return $resultSet->fetchAllAssociative();
    }


   public function findByStatus($value): array
   {

    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT t.tache_id, t.statut_id, max(t.date_changement) FROM tache_statut t
        group by t.tache_id, t.statut_id
        having t.statut_id = :value
        ';
    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery(['value' => $value]);

    return $resultSet->fetchAllAssociative();

        // 
        // ORDER BY p.price ASC
    //    return $this->createQueryBuilder('t')
    //       // ->join('t.id', 'ts','WITH','ts.statut_id=:val')
    //       // ->setParameter('val', $value)
    //        //->orderBy('t.date', 'ASC')
    //        ->andWhere("t.id in (select ts from App\Entity\TacheStatut ts)")
    //        ->getQuery()
    //        ->getResult()
    //    ;

    // $dql = "select t from App\Entity\Tache join App\Entity\TacheStatut ts where ts.statut_id = :nom";
    // return $this->getEntityManager()
    //     ->createQuery($dql)
    //     ->setParameter('nom',$value)
    //     ->getResult();

    //    return $this->createQueryBuilder('t')
    //        ->join('t.id', 'ts','WITH','ts.statut_id=:val')
    //        ->setParameter('val', $value)
    //        //->orderBy('t.date', 'ASC')
    //        ->getQuery()
    //        ->getResult()
    //    ;
   }

//    /**findByLastStatus
//     * @return Tache[] Returns an array of Tache objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tache
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
