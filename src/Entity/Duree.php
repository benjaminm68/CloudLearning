<?php

namespace App\Entity;

use App\Repository\DureeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DureeRepository::class)
 */
class Duree
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbJour;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="durees", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="durees", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $modules;

    public function __toString()
    {
        return $this->getModules().': '.$this->getNbJour().' jour(s)';
      
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJour(): ?int
    {
        return $this->nbJour;
    }

    public function setNbJour(int $nbJour): self
    {
        $this->nbJour = $nbJour;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getModules(): ?Module
    {
        return $this->modules;
    }

    public function setModules(?Module $modules): self
    {
        $this->modules = $modules;

        return $this;
    }
}
