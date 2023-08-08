<?php

namespace App\Entity;

use App\Repository\DocteurPatientLigneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocteurPatientLigneRepository::class)]
class DocteurPatientLigne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'docteurPatientLignes')]
    private ?Patient $Patient = null;

    #[ORM\ManyToOne(inversedBy: 'docteurPatientLignes')]
    private ?Docteur $Docteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patient
    {
        return $this->Patient;
    }

    public function setPatient(?Patient $Patient): self
    {
        $this->Patient = $Patient;

        return $this;
    }

    public function getDocteur(): ?Docteur
    {
        return $this->Docteur;
    }

    public function setDocteur(?Docteur $Docteur): self
    {
        $this->Docteur = $Docteur;

        return $this;
    }
}
