<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    public function getAverageByStudentId(int $studentId): float
    {
        return round(
            $this->createQueryBuilder('n')
                ->select('AVG(n.value) as average')
                ->where('n.student = :studentId')
                ->setParameter('studentId', $studentId)
                ->getQuery()
                ->getSingleScalarResult(),
            2
        );
    }

    public function getAverage(): float
    {
        return round(
            $this->createQueryBuilder('n')
                ->select('AVG(n.value)')
                ->getQuery()
                ->getSingleScalarResult(),
            2,
        );
    }
}
