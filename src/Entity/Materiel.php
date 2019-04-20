<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MaterielRepository")
 */
class Materiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $serie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sys_expl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_proc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hdd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ad_ip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ad_wifi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service")
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Emplacement")
     */
    private $emplacement;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur")
     */
    private $utilisteurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etat", mappedBy="materiel")
     */
    private $etats;

    public function __construct()
    {
        $this->utilisteurs = new ArrayCollection();
        $this->etats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumId(): ?string
    {
        return $this->num_id;
    }

    public function setNumId(string $num_id): self
    {
        $this->num_id = $num_id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function setSerie(string $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getSysExpl(): ?string
    {
        return $this->sys_expl;
    }

    public function setSysExpl(?string $sys_expl): self
    {
        $this->sys_expl = $sys_expl;

        return $this;
    }

    public function getRam(): ?string
    {
        return $this->ram;
    }

    public function setRam(?string $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getTypeProc(): ?string
    {
        return $this->type_proc;
    }

    public function setTypeProc(?string $type_proc): self
    {
        $this->type_proc = $type_proc;

        return $this;
    }

    public function getHdd(): ?string
    {
        return $this->hdd;
    }

    public function setHdd(?string $hdd): self
    {
        $this->hdd = $hdd;

        return $this;
    }

    public function getAdIp(): ?string
    {
        return $this->ad_ip;
    }

    public function setAdIp(?string $ad_ip): self
    {
        $this->ad_ip = $ad_ip;

        return $this;
    }

    public function getAdWifi(): ?string
    {
        return $this->ad_wifi;
    }

    public function setAdWifi(?string $ad_wifi): self
    {
        $this->ad_wifi = $ad_wifi;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getEmplacement(): ?Emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(?Emplacement $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisteurs(): Collection
    {
        return $this->utilisteurs;
    }

    public function addUtilisteur(Utilisateur $utilisteur): self
    {
        if (!$this->utilisteurs->contains($utilisteur)) {
            $this->utilisteurs[] = $utilisteur;
        }

        return $this;
    }

    public function removeUtilisteur(Utilisateur $utilisteur): self
    {
        if ($this->utilisteurs->contains($utilisteur)) {
            $this->utilisteurs->removeElement($utilisteur);
        }

        return $this;
    }

    /**
     * @return Collection|Etat[]
     */
    public function getEtats(): Collection
    {
        return $this->etats;
    }

    public function addEtat(Etat $etat): self
    {
        if (!$this->etats->contains($etat)) {
            $this->etats[] = $etat;
            $etat->setMateriel($this);
        }

        return $this;
    }

    public function removeEtat(Etat $etat): self
    {
        if ($this->etats->contains($etat)) {
            $this->etats->removeElement($etat);
            // set the owning side to null (unless already changed)
            if ($etat->getMateriel() === $this) {
                $etat->setMateriel(null);
            }
        }

        return $this;
    }


}
