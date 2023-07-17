<?php

namespace App\Entity\traits;

use App\Entity\City;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait ContactTrait
{
    #[ORM\Column(length:255)]
    #[Groups('prospect')]
    private string $name;

    #[ORM\Column(length:20,unique:true)]
    #[Groups('prospect')]
    private string $phoneNumber;


    
    #[ORM\ManyToOne(targetEntity: City::class)]
    #[ORM\JoinColumn(nullable:false)]
    #[Groups('prospect')]
    private City $city;

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
     * Get the value of city
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * Set the value of city
     */
    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
