<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $DateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlaces;

    /**
     * @ORM\ManyToMany(targetEntity=Stagiaire::class, inversedBy="sessions")
     */
    private $participer;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="sessions")
     */
    private $contenir;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    public function __construct()
    {
        $this->participer = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom.' | '.$this->dateDebut->format('d/m/Y').' - '.$this->DateFin->format('d/m/Y');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    /**
     * @return Collection|Stagiaire[]
     */
    public function getParticiper(): Collection
    {
        return $this->participer;
    }

    public function addParticiper(Stagiaire $participer): self
    {
        if (!$this->participer->contains($participer)) {
            $this->participer[] = $participer;
        }

        return $this;
    }

    public function removeParticiper(Stagiaire $participer): self
    {
        $this->participer->removeElement($participer);

        return $this;
    }

    public function getContenir(): ?Formation
    {
        return $this->contenir;
    }

    public function setContenir(?Formation $contenir): self
    {
        $this->contenir = $contenir;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
