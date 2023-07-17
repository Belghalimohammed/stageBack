<?php

namespace App\EventListener;

use App\Entity\Client;
use App\Exception\EntityExistException;
use App\Repository\ClientRepository;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ClientListener
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

   
    /**
    * @param PrePersistEventArgs $args
    */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
       
        if ($entity instanceof Client) {
            
            $this->checkClientOnAdd($entity);
        }
    }

    /**
    * @param PreUpdateEventArgs $args
    */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
       
        if ($entity instanceof Client) {
            if($args->hasChangedField('email'))
            {
                $this->checkEmailOnUpdate($entity);
            }
            if($args->hasChangedField('phoneNumber'))
            {
                $this->checkPhoneNumberOnUpdate($entity);
            }
        }
    }



    private function checkClientOnAdd(Client $client): void
    {
        
        if ($this->clientRepository->checkExistance($client->getEmail(),$client->getPhoneNumber()) !== []) {
            throw new EntityExistException('the entity exist',305);
        }
    }

    private function checkEmailOnUpdate(Client $client): void
    {
        if($this->clientRepository->checkEmailExistanceOnUpdate($client->getEmail(),$client->getId()) !== [])
        {
            throw new EntityExistException('the email exist',305);
        }
    }

    private function checkPhoneNumberOnUpdate(Client $client): void
    {
        if($this->clientRepository->checkPhoneNumberExistanceOnUpdate($client->getPhoneNumber(),$client->getId()) !== [])
        {
            throw new EntityExistException('the phone number exist',305);
        }
    }


    
}

