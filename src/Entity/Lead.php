<?php

namespace App\Entity;

use App\Repository\LeadRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use DateTime;

#[ORM\Entity(repositoryClass: LeadRepository::class)]
#[UniqueEntity(fields: ['leadid'], message: 'A lead with this ID already exists in our database.')]
#[UniqueEntity(fields: ['vin'], message: 'A vehicle with this VIN already exists in our database.')]
class Lead
{
    #[ORM\Id]
    #[ORM\Column()]
    private int $leadid;

    #[ORM\Column(length: 8)]
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Length(min: 5, max: 8)
    ])]
    private string $postcode;

    #[ORM\reg(length: 8)]
    #[Assert\NotBlank]
    private string $reg;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $model;

    #[ORM\Column(length: 4, name: 'reg_year')]
    #[Assert\NotBlank]
    private int $regYear;

    #[ORM\Column(length: 4, name: 'cylinder_capacity')]
    #[Assert\NotBlank]
    private int $cylinderCapacity;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $colour;

    #[ORM\OneToMany(targetEntity: KeeperHistory::class, mappedBy: 'lead', cascade: ['persist', 'remove'])]
    #[Assert\NotBlank]
    private Collection $keepers;

    #[ORM\Column(length: 2, name: 'keepers_count')]
    #[Assert\NotBlank]
    private int $keepersCount;

    #[ORM\Column(length: 15)]
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Regex(pattern: '/^[0-9]{10,15}$/')
    ])]
    private string $contact;

    #[ORM\Column(length: 255)]
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Email()
    ])]
    private string $email;

    #[ORM\Column(length: 56)]
    #[Assert\NotBlank]
    private string $fuel;

    #[ORM\Column(length: 56)]
    #[Assert\NotBlank]
    private string $transmission;

    #[ORM\Column(length: 2)]
    #[Assert\NotBlank]
    private int $doors;

    #[ORM\Column(type: 'datetime', name: 'mot_due')]
    #[Assert\NotBlank]
    private DateTime $motDue;

    #[ORM\Column(length: 17)]
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Regex(pattern: '/^[A-Z0-9]{17}$/')
    ])]
    private string $vin;

    #[ORM\Column(length: 7)]
    #[Assert\NotBlank]
    private string $status;

    public function __construct()
    {
        $this->keepers = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->leadid;
    }

    public function setId(int $leadid): void
    {
        $this->leadid = $leadid;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }

    public function getReg(): string
    {
        return $this->reg;
    }

    public function setReg(string $reg): void
    {
        $this->reg = $reg;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getRegYear(): int
    {
        return $this->regYear;
    }

    public function setRegYear(int $regYear): void
    {
        $this->regYear = $regYear;
    }

    public function getCylinderCapacity(): int
    {
        return $this->cylinderCapacity;
    }

    public function setCylinderCapacity(int $cylinderCapacity): void
    {
        $this->cylinderCapacity = $cylinderCapacity;
    }

    public function getcolour(): string
    {
        return $this->colour;
    }

    public function setColour(string $colour): void
    {
        $this->colour = $colour;
    }

    public function getKeepers(): Collection
    {
        return $this->keepers;
    }

    public function getKeepersCount(): int
    {
        return $this->keepersCount;
    }

    public function setKeepersCount(int $keepersCount): void
    {
        $this->keepersCount = $keepersCount;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function setContact(string $contact): void
    {
        $this->contact = $contact;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFuel(): string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): void
    {
        $this->fuel = $fuel;
    }

    public function getTransmission(): string
    {
        return $this->transmission;
    }

    public function setTransmission(string $transmission): void
    {
        $this->transmission = $transmission;
    }

    public function getDoors(): int
    {
        return $this->doors;
    }

    public function setDoors(int $doors): void
    {
        $this->doors = $doors;
    }

    public function getMotDue(): DateTime
    {
        return $this->motDue;
    }

    public function setMotDue(DateTime $motDue): void
    {
        $this->motDue = $motDue;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function setVin(string $vin): void
    {
        $this->vin = $vin;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

}
