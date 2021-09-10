<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function search(array $params)
    {
        $qB = $this->createQueryBuilder('f');

        if (!empty($params['strSearch'])) {
            $qB->andWhere('f.titre LIKE :strSearch OR f.synopsis LIKE :strSearch')
               ->setParameter('strSearch', '%'.$params['strSearch'].'%');
        }

        if (!empty($params['acteur'])) {
            $qB->join('f.acteurs', 'a')
                ->andWhere('a.id = :acteurId')
                ->setParameter('acteurId', $params['acteur']);
        }

        if (!empty($params['dateDebut'])) {
            $qB->andWhere('f.annee >= :dateDebut')
                ->setParameter('dateDebut', $params['dateDebut']);
        }

        if (!empty($params['dateFin'])) {
            $qB->andWhere('f.annee <= :dateFin')
                ->setParameter('dateFin', $params['dateFin']);
        }

        return $qB->getQuery()->getResult();
/*
        return $this->createQueryBuilder('f')
            ->where('f.titre LIKE :strSearch OR f.synopsis LIKE :strSearch')
            ->setParameters([
                'strSearch' => '%'.$params['strSearch'].'%',
            ])
            ->getQuery()
            ->getResult();
*/
    }

    // /**
    //  * @return Film[] Returns an array of Film objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Film
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
