<?php

namespace App\Entity;

use App\Entity\traits\DateTimeTrace;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\InvoiceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['prospect']])]
#[ApiResource]
class Invoice
{
    use DateTimeTrace;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('prospect')]
    private int $id;

    #[ORM\Column(type:"string", length:"20",unique:true)]
    #[Groups('prospect')]
    private string $reference;

    #[ORM\Column(type:"string")]
    private string $fileName;
    
    #[ORM\OneToOne(targetEntity: Contract::class)]
    #[ORM\JoinColumn(nullable: false,onDelete:"CASCADE")]
    private Contract $contract;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }
  

    

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

   
  

    /**
     * Get the value of reference
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Set the value of reference
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

 
    /**
     * Get the value of fileName
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     */
    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the value of contract
     */
    public function getContract(): Contract
    {
        return $this->contract;
    }

    /**
     * Set the value of contract
     */
    public function setContract(Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }
}

