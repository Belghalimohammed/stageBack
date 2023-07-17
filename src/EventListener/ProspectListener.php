<?php

namespace App\EventListener;

use App\Entity\Prospect;
use App\Exception\EntityExistException;
use App\Repository\ProspectRepository;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ProspectListener
{
    private $prospectRepository;
    public function __construct(ProspectRepository $prospectRepository)
    {
        $this->prospectRepository = $prospectRepository;
    }

    /**
     * @param PrePersistEventArgs $args
     */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Prospect) {
            $this->checkProspectOnPost($entity);
        }

    }

     /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Prospect && $args->hasChangedField('phoneNumber')) {
            $this->checkProspectOnUpdate($entity);
        }

    }

    private function checkProspectOnPost(Prospect $prospect): void
    {
        if ($this->prospectRepository->findOneBy(['phoneNumber'=>$prospect->getPhoneNumber()]) !== null) {
            throw new EntityExistException('The Phone Number already exist',305);
        }
    }

    private function checkProspectOnUpdate(Prospect $prospect): void
    {
        if ($this->prospectRepository->checkExistance($prospect->getPhoneNumber(),$prospect->getId()) !== []) {
            throw new EntityExistException('The Phone Number already exist',305);
        }
    }

    
}

