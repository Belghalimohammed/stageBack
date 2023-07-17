<?php

namespace App\EventListener;

use App\Entity\City;
use App\Exception\EntityExistException;
use App\Repository\CityRepository;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class CityListener
{
    private $cityRepository;
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param PrePersistEventArgs $args
     */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof City) {
            $this->checkCity($entity);
        }

    }

     /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof City && $args->hasChangedField('name')) {
            $this->checkCity($entity);
        }

    }

    private function checkCity(City $city): void
    {
        if ($this->cityRepository->findOneBy(['name'=>$city->getName()]) !== null) {
            throw new EntityExistException('the entity exist',305);
        }
    }

    
}

