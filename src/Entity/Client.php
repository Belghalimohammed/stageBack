<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Entity\traits\ContactTrait;
use App\Entity\traits\DateTimeTrace;
use App\Repository\ClientRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['prospect']])]
class Client
{
    use ContactTrait;
    use DateTimeTrace;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('prospect')]
    private int $id;


    #[ORM\Column(length:255)]
    #[Groups('prospect')]
    private string $adresse;

    #[ORM\Column(length:50,unique:true)]
    #[Groups('prospect')]
    private string $email;

    #[ORM\Column(length:100)]
    #[Groups('prospect')]
    private string $manager;

    #[ORM\OneToMany(targetEntity: Contract::class, mappedBy: 'client')]
    #[Groups('prospect')]
    private Collection $contracts;

    
   

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
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
     * Get the value of adresse
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     */
    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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
     * Get the value of manager
     */
    public function getManager(): string
    {
        return $this->manager;
    }

    /**
     * Set the value of manager
     */
    public function setManager(string $manager): self
    {
        $this->manager = $manager;

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
