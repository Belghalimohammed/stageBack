<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Repository\SalesRepRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SalesRepRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['prospect']])]
class SalesRep
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('prospect')]
    private int $id;

    #[ORM\Column(length:255)]
    #[Groups('prospect')]
    private string $name;

    #[ORM\Column(length:255)]
    #[Groups('prospect')]
    private string $familyName;

    #[ORM\Column(length:255,unique:true)]
    private string $email;

    #[ORM\Column(length:20,unique:true)]
    private string $phoneNumber;

    #[ORM\OneToMany(targetEntity: Contract::class, mappedBy: 'salesRep')]
    private Collection $contracts;


    public function __construct()
    {
        $this->contracts = new ArrayCollection();
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
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of familyName
     */
    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * Set the value of familyName
     */
    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of contracts
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    /**
     * Set the value of contracts
     */
    public function setContracts(Collection $contracts): self
    {
        $this->contracts = $contracts;

        return $this;
    }

    
}

