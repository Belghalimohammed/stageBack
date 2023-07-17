<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProspectRepository;
use App\Entity\traits\ContactTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProspectRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['prospect']])]
class Prospect
{
    use ContactTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('prospect')]
    private int $id;


  

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

  
}


