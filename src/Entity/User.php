<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="il exsiste deja un utilisateur avec cet email")
 */
class User implements UserInterface, \Serializable
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motdepasse;

    /**
     * Mot de passe en clair pour interagir avec le formulaire
     * d'inscription
     * @var string
     *
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $role = 'ROLE_USER';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="date")
     */
    private $date_de_naissance;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="auteur")
     * @ORM\OrderBy({"datePublication":"DESC"})
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="auteur")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="auteur")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="destinataire")
     */
    private $messagesRecus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="user")
     * @ORM\OrderBy({"datePublication":"DESC"})
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Amis", mappedBy="suiveur")
     */
    private $amis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Amis", mappedBy="suivi")
     */
    private $amisSuivi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resultatquizz", mappedBy="user")
     */
    private $resultatquizzs;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->messagesRecus = new ArrayCollection();

        $this->photos = new ArrayCollection();

        $this->amis = new ArrayCollection();
        $this->amisSuivi = new ArrayCollection();
        $this->resultatquizzs = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $date_de_naissance): self
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuteur($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuteur() === $this) {
                $article->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setAuteur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuteur() === $this) {
                $commentaire->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAuteur($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getAuteur() === $this) {
                $message->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function __toString()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesRecus(): Collection
    {
        return $this->messagesRecus;
    }

    public function addMessagesRecus(Message $messagesRecus): self
    {
        if (!$this->messagesRecus->contains($messagesRecus)) {
            $this->messagesRecus[] = $messagesRecus;
            $messagesRecus->setDestinataire($this);
        }

        return $this;
    }

    public function removeMessagesRecus(Message $messagesRecus): self
    {
        if ($this->messagesRecus->contains($messagesRecus)) {
            $this->messagesRecus->removeElement($messagesRecus);
            // set the owning side to null (unless already changed)
            if ($messagesRecus->getDestinataire() === $this) {
                $messagesRecus->setDestinataire(null);
            }
        }

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return [$this->role];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->motdepasse;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setUser($this);
        }
    }



    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getUser() === $this) {
                $photo->setUser(null);
            }
        }
    }

    /**
     * @return Collection|Amis[]
     */
    public function getAmis(): Collection
    {
        return $this->amis;
    }

    public function addAmi(Amis $ami): self
    {
        if (!$this->amis->contains($ami)) {
            $this->amis[] = $ami;
            $ami->setSuiveur($this);

        }

        return $this;
    }

    public function removeAmi(Amis $ami): self
    {
        if ($this->amis->contains($ami)) {
            $this->amis->removeElement($ami);
            // set the owning side to null (unless already changed)
            if ($ami->getSuiveur() === $this) {
                $ami->setSuiveur(null);

            }
        }

        return $this;
    }

    public function getAmisSuivi(): Collection
    {
        return $this->amisSuivi;
    }

    public function addAmiSuivi(Amis $ami): self
    {
        if (!$this->amisSuivi->contains($ami)) {
            $this->amisSuivi[] = $ami;
            $ami->setSuivi($this);

        }

        return $this;
    }

    public function removeAmiSuivi(Amis $ami): self
    {
        if ($this->amisSuivi->contains($ami)) {
            $this->amisSuivi->removeElement($ami);
            // set the owning side to null (unless already changed)
            if ($ami->getSuivi() === $this) {
                $ami->setSuivi(null);

            }
        }

        return $this;
    }



    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->prenom,
            $this->nom,
            $this->email,
            $this->motdepasse


        ));
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->prenom,
            $this->nom,
            $this->email,
            $this->motdepasse
            ) = unserialize($serialized);
    }

    /**
     * @return Collection|Resultatquizz[]
     */
    public function getResultatquizzs(): Collection
    {
        return $this->resultatquizzs;
    }

    public function addResultatquizz(Resultatquizz $resultatquizz): self
    {
        if (!$this->resultatquizzs->contains($resultatquizz)) {
            $this->resultatquizzs[] = $resultatquizz;
            $resultatquizz->setUser($this);
        }

        return $this;
    }

    public function removeResultatquizz(Resultatquizz $resultatquizz): self
    {
        if ($this->resultatquizzs->contains($resultatquizz)) {
            $this->resultatquizzs->removeElement($resultatquizz);
            // set the owning side to null (unless already changed)
            if ($resultatquizz->getUser() === $this) {
                $resultatquizz->setUser(null);
            }
        }

        return $this;
    }
}
