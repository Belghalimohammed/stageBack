<?php

namespace App\Repository;

use App\Entity\Prospect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProspectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prospect::class);
    }

    public function checkExistance(string $number,int $id)
    {
        return $this->createQueryBuilder('c')
            ->where("c.phoneNumber = :number")
            ->andWhere("c.id != :id")
            ->setParameter('number', $number)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
   
    
}

