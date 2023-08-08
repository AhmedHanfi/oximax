<?php

namespace App\Entity;

use App\Repository\DocteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocteurRepository::class)]
class Docteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    private ?string $cabinet = null;

    #[ORM\OneToOne(inversedBy: 'docteur', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'Docteur', targetEntity: DocteurPatientLigne::class)]
    private Collection $docteurPatientLignes;

    public function __construct()
    {
        $this->docteurPatientLignes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCabinet(): ?string
    {
        return $this->cabinet;
    }

    public function setCabinet(string $cabinet): self
    {
        $this->cabinet = $cabinet;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, DocteurPatientLigne>
     */
    public function getDocteurPatientLignes(): Collection
    {
        return $this->docteurPatientLignes;
    }

    public function addDocteurPatientLigne(DocteurPatientLigne $docteurPatientLigne): self
    {
        if (!$this->docteurPatientLignes->contains($docteurPatientLigne)) {
            $this->docteurPatientLignes->add($docteurPatientLigne);
            $docteurPatientLigne->setDocteur($this);
        }

        return $this;
    }

    public function removeDocteurPatientLigne(DocteurPatientLigne $docteurPatientLigne): self
    {
        if ($this->docteurPatientLignes->removeElement($docteurPatientLigne)) {
            // set the owning side to null (unless already changed)
            if ($docteurPatientLigne->getDocteur() === $this) {
                $docteurPatientLigne->setDocteur(null);
            }
        }

        return $this;
    }

}
