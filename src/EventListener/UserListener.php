<?php

namespace App\EventListener;

use App\Entity\User;
use App\Exception\EntityExistException;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class UserListener
{
    private $mailer;
    private $userRepository;
    public function __construct(MailerService $mailer,UserRepository $userRepository)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

    /**
     * @param PrePersistEventArgs $args
     */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            $this->checkUserOnAdd($entity);
            $entity->setPassword($this->generatePassword());
            $this->mailer->sendTmpPassword($entity);
        }

        
    }

    /**
    * @param PreUpdateEventArgs $args
    */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
       
        if ($entity instanceof User && $args->hasChangedField('email')) {
            $this->checkUserOnUpdate($entity);
        }
    }

    public function generatePassword() : string
    {
        return  bin2hex(random_bytes(3));
    }

    private function checkUserOnAdd(User $user): void
    {
        if ($this->userRepository->findOneBy(['email'=>$user->getEmail()]) !== null) {
            throw new EntityExistException('the entity exist',305);
        }
    }

    private function checkUserOnUpdate(User $user): void
    {
        if ($this->userRepository->checkExistance($user->getEmail(),$user->getId()) !== []) {
            throw new EntityExistException('the entity exist',305);
        }
    }

    
}

