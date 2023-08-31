<?php

namespace App\Repository;

use App\Entity\Acceuil;
use App\Entity\Docteur;
use App\Entity\Patient;
use App\Entity\Responsable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patient>
 *
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    public function save(Patient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Patient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTotalCounts(): array
    {
        $totalPatients = $this->count([]);

        $em = $this->getEntityManager();
        $docteurCount = $em->getRepository(Docteur::class)->count([]);
        $responsableCount = $em->getRepository(Responsable::class)->count([]);
        $acceuilCount = $em->getRepository(Acceuil::class)->count([]);

        $malePatientCount = $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.Genre = :male')
            ->setParameter('male', 'Mr')
            ->getQuery()
            ->getSingleScalarResult();

        $femalePatientCount = $totalPatients - $malePatientCount;
        return [
            'totalAcceuils' => $acceuilCount,
            'totalPatients' => $totalPatients,
            'totalDoctors' => $docteurCount,
            'totalResponsables' => $responsableCount,
            'malePatientCount' => $malePatientCount,
            'femalePatientCount' => $femalePatientCount,
        ];
    }

//    /**
//     * @return Patient[] Returns an array of Patient objects
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

//    public function findOneBySomeField($value): ?Patient
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
