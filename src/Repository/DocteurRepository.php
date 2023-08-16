<?php

namespace App\Repository;

use App\Entity\Docteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Docteur>
 *
 * @method Docteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Docteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Docteur[]    findAll()
 * @method Docteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Docteur::class);
    }

    public function save(Docteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Docteur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // DocteurRepository.php

    // ...

    public function findPatientsByDoctor(Docteur $doctor): array
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('dpl')
            ->from('App\Entity\DocteurPatientLigne', 'dpl')
            ->join('dpl.Patient', 'p')
            ->where('dpl.Docteur = :doctor')
            ->setParameter('doctor', $doctor)
            ->getQuery()
            ->getResult();

        return $query;
    }



    //    /**
    //     * @return Docteur[] Returns an array of Docteur objects
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

    //    public function findOneBySomeField($value): ?Docteur
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
