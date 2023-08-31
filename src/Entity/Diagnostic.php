<?php

namespace App\Entity;

use App\Repository\DiagnosticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiagnosticRepository::class)]
class Diagnostic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $maladie = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prescription = null;

    #[ORM\ManyToOne(inversedBy: 'diagnostics')]
    private ?Patient $patient = null;

    #[ORM\Column(length: 20)]
    private ?string $etat = null;

    #[ORM\OneToMany(mappedBy: 'diagnostic', targetEntity: HistoriqueDiagnostic::class, cascade: [])]
    private Collection $historiqueDiagnostics;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreaction = null;

    public function __construct()
    {
        $this->historiqueDiagnostics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaladie(): ?string
    {
        return $this->maladie;
    }

    public function setMaladie(string $maladie): self
    {
        $this->maladie = $maladie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrescription(): ?string
    {
        return $this->prescription;
    }

    public function setPrescription(?string $prescription): self
    {
        $this->prescription = $prescription;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, HistoriqueDiagnostic>
     */
    public function getHistoriqueDiagnostics(): Collection
    {
        return $this->historiqueDiagnostics;
    }

    public function addHistoriqueDiagnostic(HistoriqueDiagnostic $historiqueDiagnostic): self
    {
        if (!$this->historiqueDiagnostics->contains($historiqueDiagnostic)) {
            $this->historiqueDiagnostics->add($historiqueDiagnostic);
            $historiqueDiagnostic->setDiagnostic($this);
        }

        return $this;
    }

    public function removeHistoriqueDiagnostic(HistoriqueDiagnostic $historiqueDiagnostic): self
    {
        if ($this->historiqueDiagnostics->removeElement($historiqueDiagnostic)) {
            // set the owning side to null (unless already changed)
            if ($historiqueDiagnostic->getDiagnostic() === $this) {
                $historiqueDiagnostic->setDiagnostic(null);
            }
        }

        return $this;
    }

    public function getDateCreaction(): ?\DateTimeInterface
    {
        return $this->dateCreaction;
    }

    public function setDateCreaction(\DateTimeInterface $dateCreaction): self
    {
        $this->dateCreaction = $dateCreaction;

        return $this;
    }

}
