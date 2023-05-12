<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbVisiteursAdultes = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbVisiteursEnfants = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureArrivee = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateHeureDepart = null;

    #[ORM\ManyToMany(targetEntity: Exposition::class, inversedBy: 'visites')]
    private Collection $Exposition;

    public function __construct()
    {
        $this->Exposition = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbVisiteursAdultes(): ?int
    {
        return $this->nbVisiteursAdultes;
    }

    public function setNbVisiteursAdultes(int $nbVisiteursAdultes): self
    {
        $this->nbVisiteursAdultes = $nbVisiteursAdultes;

        return $this;
    }

    public function getNbVisiteursEnfants(): ?int
    {
        return $this->nbVisiteursEnfants;
    }

    public function setNbVisiteursEnfants(?int $nbVisiteursEnfants): self
    {
        $this->nbVisiteursEnfants = $nbVisiteursEnfants;

        return $this;
    }

    public function getDateHeureArrivee(): ?\DateTimeInterface
    {
        return $this->dateHeureArrivee;
    }

    public function setDateHeureArrivee(\DateTimeInterface $dateHeureArrivee): self
    {
        $this->dateHeureArrivee = $dateHeureArrivee;

        return $this;
    }

    public function getDateHeureDepart(): ?\DateTimeInterface
    {
        return $this->dateHeureDepart;
    }

    public function setDateHeureDepart(?\DateTimeInterface $dateHeureDepart): self
    {
        $this->dateHeureDepart = $dateHeureDepart;

        return $this;
    }

    /**
     * @return Collection<int, Exposition>
     */
    public function getExposition(): Collection
    {
        return $this->Exposition;
    }

    public function addExposition(Exposition $exposition): self
    {
        if (!$this->Exposition->contains($exposition)) {
            $this->Exposition->add($exposition);
        }

        return $this;
    }

    public function removeExposition(Exposition $exposition): self
    {
        $this->Exposition->removeElement($exposition);

        return $this;
    }
}
