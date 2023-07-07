<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $Genre = null;

    #[ORM\Column]
    private ?int $Numidentite = null;

    #[ORM\Column(length: 100)]
    private ?string $Adress = null;

    #[ORM\Column(length: 255)]
    private ?string $Mail = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $etat_patient = null;

    #[ORM\ManyToMany(targetEntity: Docteur::class, mappedBy: 'patients_ids')]
    private Collection $docteurs;

    public function __construct()
    {
        $this->docteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

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

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getNumidentite(): ?int
    {
        return $this->Numidentite;
    }

    public function setNumidentite(int $Numidentite): self
    {
        $this->Numidentite = $Numidentite;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): self
    {
        $this->Adress = $Adress;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getEtatPatient(): ?string
    {
        return $this->etat_patient;
    }

    public function setEtatPatient(?string $etat_patient): self
    {
        $this->etat_patient = $etat_patient;

        return $this;
    }

    /**
     * @return Collection<int, Docteur>
     */
    public function getDocteurs(): Collection
    {
        return $this->docteurs;
    }

    public function addDocteur(Docteur $docteur): self
    {
        if (!$this->docteurs->contains($docteur)) {
            $this->docteurs->add($docteur);
            $docteur->addPatientsId($this);
        }

        return $this;
    }

    public function removeDocteur(Docteur $docteur): self
    {
        if ($this->docteurs->removeElement($docteur)) {
            $docteur->removePatientsId($this);
        }

        return $this;
    }
}
