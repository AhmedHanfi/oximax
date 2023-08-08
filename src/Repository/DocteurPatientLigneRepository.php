<?php

namespace App\Repository;

use App\Entity\DocteurPatientLigne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocteurPatientLigne>
 *
 * @method DocteurPatientLigne|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocteurPatientLigne|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocteurPatientLigne[]    findAll()
 * @method DocteurPatientLigne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocteurPatientLigneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocteurPatientLigne::class);
    }

    public function save(DocteurPatientLigne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DocteurPatientLigne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DocteurPatientLigne[] Returns an array of DocteurPatientLigne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DocteurPatientLigne
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
