<?php
//c'est un test bande de batards
namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 */
class Module
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptif;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $appartenir;

    /**
     * @ORM\OneToMany(targetEntity=Duree::class, mappedBy="modules")
     */
    private $durees;

    public function __construct()
    {
        $this->durees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getAppartenir(): ?Categorie
    {
        return $this->appartenir;
    }

    public function setAppartenir(?Categorie $appartenir): self
    {
        $this->appartenir = $appartenir;

        return $this;
    }

    /**
     * @return Collection|Duree[]
     */
    public function getDurees(): Collection
    {
        return $this->durees;
    }

    public function addDuree(Duree $duree): self
    {
        if (!$this->durees->contains($duree)) {
            $this->durees[] = $duree;
            $duree->setModules($this);
        }

        return $this;
    }

    public function removeDuree(Duree $duree): self
    {
        if ($this->durees->removeElement($duree)) {
            // set the owning side to null (unless already changed)
            if ($duree->getModules() === $this) {
                $duree->setModules(null);
            }
        }

        return $this;
    }
}
