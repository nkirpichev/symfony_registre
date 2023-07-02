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
    
    public function findByLastStatus($value): array
    {
 
     //$dql = "select t1, t2 from App\Entity\TacheStatut t1 join t1.tache t2 ";
     //return $this->getEntityManager()
    //     ->createQuery($dql)
        // ->setParameter('nom',$value)
       //  ->getResult();
 //where t1.statut.id = :nom
        return $this->createQueryBuilder('t')
            //->select('t')
            ->Select('st')
            ->addSelect('ts')
            ->addSelect('max(t.dateChangement)')
            ->join('App\Entity\Statut','st')
            ->join('App\Entity\Tache','ts')
            ->groupBy('t.tache, t.statut')
            //->groupBy('')
            ->andHaving('t.statut = :val')
            ->setParameter('val', $value)
           // ->orderBy('t.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;


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
