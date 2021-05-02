<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\User;
use App\Enum\AccountTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

     /**
      * @return Article[] Returns an array of Article objects
     */

    public function findAllVisible(): array
    {
        return $this->findAllVisibleQuery()
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findArticles(User $user)
    {
        $qb = $this->createQueryBuilder('a');
        if ($user->getType() === AccountTypeEnum::AUTEUR) {
            $qb->where('a.auteur = :auteur')
                ->setParameter('auteur', $user);
        }

        $qb->orderBy('a.created', 'DESC');

        return $qb->getQuery()
            ;
    }
}
