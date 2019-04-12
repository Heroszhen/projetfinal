<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function search(User $user1, User $user2)
    {
        // constructeur de requete sql
        // le 'a' est l'alias de la table article dans la requete
        $qb = $this->createQueryBuilder('m');

        // tri par date de publication croissante
        $qb->orderBy('m.publicationDate', 'ASC');

        $qb
            ->orWhere('m.auteur :user1')
            ->orWhere('m.auteur :user2')
            ->orWhere('m.destinataire :user1')
            ->orWhere('m.destinataire :user2')
            ->setParameter('user1', $user1)
            ->setParameter('user2', $user2)
        ;
        // la requqete est generee
        $query = $qb->getQuery();

        // on retourne le resultat de la requete
        return $query->getResult();
    }
}
