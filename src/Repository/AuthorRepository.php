<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
    public function getAuthorByUserName($username): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.username = :v')
            ->setParameter('v', $username)
            ->orderBy('a.username', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAuthorByUserNameDQL($username): array
    {
        $em = $this->getEntityManager(); 

        $query= $em->createQuery('SELECT a FROM App\Entity\Author a 
        WHERE a.username = :name ORDER BY a.username ASC'); 
        $query->setParameter('name', $username); 
        return $query->getResult();  
        
    }
   

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
