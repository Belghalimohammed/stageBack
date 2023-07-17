<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Entity\Created as EntityCreated;
use App\Entity\traits\Created as TraitsCreated;
use App\Entity\traits\DateTimeTrace;
use App\Repository\ContractRepository;
use Created;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['prospect']])]
class Contract
{
    use DateTimeTrace;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('prospect')]
    private int $id;


    #[ORM\Column(type:"datetime")]
    #[Groups('prospect')]
    private  DateTime $startDate;

    #[ORM\Column(type:"datetime")]
    #[Groups('prospect')]
    private  DateTime $endDate;

    #[ORM\Column(type:"string", length:"20",unique:true)]
    #[Groups('prospect')]
    private string $number;

    #[ORM\Column(type:"decimal")]
    #[Groups('prospect')]
    private float $price;

    #[ORM\Column(type:"integer",options: ["default" => 3])]
    #[Groups('prospect')]
    private float $nbrAccess;
  
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false,onDelete:"CASCADE")]
    private Client $client;

    #[ORM\ManyToOne(targetEntity: SalesRep::class, inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('prospect')]
    private SalesRep $salesRep;

  

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
     * Get the value of price
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

  

    /**
     * Get the value of client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Set the value of client
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get the value of startDate
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     */
    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     */
    public function setEndDate(DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of salesRep
     */
    public function getSalesRep(): SalesRep
    {
        return $this->salesRep;
    }

    /**
     * Set the value of salesRep
     */
    public function setSalesRep(SalesRep $salesRep): self
    {
        $this->salesRep = $salesRep;

        return $this;
    }

    /**
     * Get the value of number
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Set the value of number
     */
    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the value of nbrAccess
     */
    public function getNbrAccess(): float
    {
        return $this->nbrAccess;
    }

    /**
     * Set the value of nbrAccess
     */
    public function setNbrAccess(float $nbrAccess): self
    {
        $this->nbrAccess = $nbrAccess;

        return $this;
    }
}


