<?php

namespace App\Repository;

use App\Entity\CurrentAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CurrentAccount>
 *
 * @method CurrentAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrentAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrentAccount[]    findAll()
 * @method CurrentAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrentAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrentAccount::class);
    }

    public function save(CurrentAccount $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CurrentAccount $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllActivated() {
        return $this->createQueryBuilder("ca")
            ->andWhere("ca.status = 1")
            ->getQuery()
            ->getResult();
    }

    public function findActivated(CurrentAccount $currentAccount) {
        return $this->createQueryBuilder("ca")
            ->andWhere("ca.status = 1")
            ->andWhere("ca.id = :idCurrentAccount")
            ->setParameter("idCurrentAccount", $currentAccount->getId())
            ->getQuery()
            ->getResult();
    }

    /*public function getAcountByMoney(EntityManagerInterface $em, $min = 0, $max = 1000000)
    {
        return $em->createQuery("SELECT c,SUM(b.money) FROM App\Entity\CurrentAccount c INNER JOIN App\Entity\Booklet b GROUP BY c.id")
            ->getArrayResult();
    }*/

//    /**
//     * @return CurrentAccount[] Returns an array of CurrentAccount objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CurrentAccount
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
