<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmisRepository")
 */
class Amis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="amis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $suiveur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="amisSuivi")
     * @ORM\JoinColumn(nullable=false)
     */
    private $suivi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuiveur(): ?User
    {
        return $this->suiveur;
    }

    public function setSuiveur(?User $suiveur): self
    {
        $this->suiveur = $suiveur;

        return $this;
    }

    public function getSuivi(): ?User
    {
        return $this->suivi;
    }

    public function setSuivi(?User $suivi): self
    {
        $this->suivi = $suivi;

        return $this;
    }
}
