<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,Client::class);
    }
    
    public function checkExistance(string $email,string $number)
    {
        return $this->createQueryBuilder('c')
            ->where("c.email = :email")
            ->orWhere("c.phoneNumber = :number")
            ->setParameter('email', $email)
            ->setParameter('number', $number)
            ->getQuery()
            ->getResult();
    }

    public function checkEmailExistanceOnUpdate(string $email,int $id)
    {
        return $this->createQueryBuilder('c')
            ->where("c.email = :email")
            ->andWhere("c.id != :id")
            ->setParameter('email', $email)
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }

    public function checkPhoneNumberExistanceOnUpdate(string $number,int $id)
    {
        return $this->createQueryBuilder('c')
            ->orWhere("c.phoneNumber = :number")
            ->andWhere("c.id != :id")
            ->setParameter('number', $number)
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }
}

