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
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="amis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $suiveur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="amis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $suivi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuiveur(): ?user
    {
        return $this->suiveur;
    }

    public function setSuiveur(?user $suiveur): self
    {
        $this->suiveur = $suiveur;

        return $this;
    }

    public function getSuivi(): ?user
    {
        return $this->suivi;
    }

    public function setSuivi(?user $suivi): self
    {
        $this->suivi = $suivi;

        return $this;
    }
}
