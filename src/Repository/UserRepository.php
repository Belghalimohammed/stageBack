<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,User::class);
    }

    public function checkExistance(string $email,int $id)
    {
        return $this->createQueryBuilder('c')
            ->where("c.email = :email")
            ->andWhere("c.id != :id")
            ->setParameter('email', $email)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    
}

