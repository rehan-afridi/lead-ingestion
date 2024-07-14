<?php

namespace App\Entity;

use App\Repository\KeeperHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KeeperHistoryRepository::class)]
class KeeperHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Lead::class, inversedBy: 'keepers')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'leadid')]
    private Lead $lead;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $keeper_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLead(): Lead
    {
        return $this->lead;
    }

    public function setLead(Lead $lead): self
    {
        $this->lead = $lead;

        return $this;
    }

    public function getKeeperName(): string
    {
        return $this->keeper_name;
    }

    public function setKeeperName(string $keeper_name): self
    {
        $this->keeper_name = $keeper_name;

        return $this;
    }
}
