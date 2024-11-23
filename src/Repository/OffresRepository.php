<?php

namespace App\Repository;

use App\Entity\Offres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Offres>
 */
class OffresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Offres::class);
    }

    
    public function paginateOffres(int $page, int $limit): PaginationInterface
    {

        return  $this->paginator->paginate(
            //$this->createQueryBuilder('o')->leftJoin('o.')->select('o', 'r'),
            $this->createQueryBuilder('o'),
            $page,
            $limit,
            // [
            //     'distinct' => false ,
            //     'sortFieldAllowList' => ['o.id', 'o.nom']
            // ]
        );
    }

    //    /**
    //     * @return Offres[] Returns an array of Offres objects
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

    //    public function findOneBySomeField($value): ?Offres
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

/**
*
* @return Offres[]
*/
public function offreIsPublish(): array
{
	return $this->createQueryBuilder('o')
        ->where('o.isActive = 1')
        ->orderBy('o.id', 'DESC')
        ->getQuery() // On génère un objet Query
        ->getResult() ;
}


/**
*
* @return Offres[]
*/
public function offreNotPublish(): array
{

	return $this->createQueryBuilder('o')
        ->where('o.isActive = 0')
        ->orderBy('o.id', 'DESC')
        ->getQuery() // On génère un objet Query
        ->getResult() ;
}


}
