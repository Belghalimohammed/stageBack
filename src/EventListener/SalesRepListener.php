<?php

namespace App\EventListener;

use App\Entity\SalesRep;
use App\Exception\EntityExistException;
use App\Repository\SalesRepRepository;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class SalesRepListener
{
    private $salesRepRepository;

    public function __construct(SalesRepRepository $salesRepRepository)
    {
        $this->salesRepRepository = $salesRepRepository;
    }

   
    /**
    * @param PrePersistEventArgs $args
    */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
       
        if ($entity instanceof SalesRep) {
            $this->checkSalesRepOnAdd($entity);
        }
    }

    /**
    * @param PreUpdateEventArgs $args
    */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
       
        if ($entity instanceof SalesRep && $args->hasChangedField('email')) {
            $this->checkSalesRepOnUpdate($entity);
        }
    }



    private function checkSalesRepOnAdd(SalesRep $salesRep): void
    {
        
        if ($this->salesRepRepository->findOneBy(['email'=>$salesRep->getEmail()]) !== null) {
            throw new EntityExistException('the entity exist',305);
        }
    }

    private function checkSalesRepOnUpdate(SalesRep $salesRep): void
    {
        
        if ($this->salesRepRepository->checkExistance($salesRep->getEmail(),$salesRep->getId()) !== []) {
            throw new EntityExistException('the entity exist',305);
        }
    }

    
}

