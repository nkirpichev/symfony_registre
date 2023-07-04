<?php

namespace App\Repository;

use App\Entity\TacheStatut;
use App\Entity\Statut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TacheStatut>
 *
 * @method TacheStatut|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheStatut|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheStatut[]    findAll()
 * @method TacheStatut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheStatutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TacheStatut::class);
    }

    public function save(TacheStatut $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TacheStatut $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function findLastByStatut($value): array
       {
     
        return $this->createQueryBuilder('t')

           ->andWhere("not exists( select 1 from App\Entity\TacheStatut t2
                        where t2.tache = t.tache and t2.dateChangement>t.dateChangement )")
           ->andWhere('t.statut = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getResult();
        
        


               // ->join('t.id', 'ts','WITH','ts.statut_id=:val')
          // ->setParameter('val', $value)
           //->orderBy('t.date', 'ASC')
        //  $sql = '
        //      SELECT t.* FROM tache_statut t
        //      where not exists( select 1 from tache_statut t2
        //             where t2.tache_id = t.tache_id and t2.date_changement>t.date_changement)
        //         and t.statut_id = :value 
        //      ';
        //  $stmt = $conn->prepare($sql);
        //  $resultSet = $stmt->executeQuery(['value' => $value]);
    
        //  return $resultSet->fetchAllAssociative();
    }    

//    /**
//     * @return TacheStatut[] Returns an array of TacheStatut objects
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

//    public function findOneBySomeField($value): ?TacheStatut
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
