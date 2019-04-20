<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterventionRepository")
 */
class Intervention
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_intervention;

    /**
     * @ORM\Column(type="text")
     */
    private $detail;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $statut;

    /**
     * @ORM\OneToOne(targetEntity="Ticket")
     * @ORM\JoinColumn(nullable=false)
     */
    private $demndeMaintenance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $intervenant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateIntervention(): ?\DateTimeInterface
    {
        return $this->date_intervention;
    }

    public function setDateIntervention(\DateTimeInterface $date_intervention): self
    {
        $this->date_intervention = $date_intervention;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDemndeMaintenance(): ?Ticket
    {
        return $this->demndeMaintenance;
    }

    public function setDemndeMaintenance(Ticket $demndeMaintenance): self
    {
        $this->demndeMaintenance = $demndeMaintenance;

        return $this;
    }

    public function getIntervenant(): ?Employe
    {
        return $this->intervenant;
    }

    public function setIntervenant(?Employe $intervenant): self
    {
        $this->intervenant = $intervenant;

        return $this;
    }

}
