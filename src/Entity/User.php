<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Entity\traits\Created as TraitsCreated;
use App\Entity\traits\DateTimeTrace;
use App\Repository\UserRepository;
use Created;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User
{
    use DateTimeTrace;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;



    #[ORM\Column(length:255)]
    private string $name;

    #[ORM\Column(length:255)]
    private string $familyName;

    #[ORM\Column(length:255,unique:true)]
    private string $email;

    #[ORM\Column(length:255)]
    private string $password;

    #[ORM\Column(type:"boolean")]
    private bool $isAdmin;


    
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
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of isAdmin
     */
    public function getIsAdmin(): string
    {
        return $this->isAdmin;
    }

    /**
     * Set the value of isAdmin
     */
    public function setIsAdmin(string $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }
}

