<?php

namespace App\Entity;

use App\Repository\MissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionsRepository::class)]
class Missions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 100)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?int $tarif = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startDateAT = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $endDateat = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column]
    private ?bool $isPourvue = null;

    #[ORM\Column]
    private ?bool $iSteletravail = null;

    #[ORM\Column(length: 100)]
    private ?string $lieuMission = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column]
    private ?int $experience = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $users = null;

    /**
     * @var Collection<int, skills>
     */
    #[ORM\ManyToMany(targetEntity: skills::class, inversedBy: 'missions')]
    private Collection $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTarif(): ?int
    {
        return $this->tarif;
    }

    public function setTarif(?int $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getStartDateAT(): ?\DateTimeImmutable
    {
        return $this->startDateAT;
    }

    public function setStartDateAT(\DateTimeImmutable $startDateAT): static
    {
        $this->startDateAT = $startDateAT;

        return $this;
    }

    public function getEndDateat(): ?\DateTimeImmutable
    {
        return $this->endDateat;
    }

    public function setEndDateat(\DateTimeImmutable $endDateat): static
    {
        $this->endDateat = $endDateat;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function isPourvue(): ?bool
    {
        return $this->isPourvue;
    }

    public function setPourvue(bool $isPourvue): static
    {
        $this->isPourvue = $isPourvue;

        return $this;
    }

    public function isTeletravail(): ?bool
    {
        return $this->iSteletravail;
    }

    public function setIsTeletravail(bool $iSteletravail): static
    {
        $this->iSteletravail = $iSteletravail;

        return $this;
    }

    public function getLieuMission(): ?string
    {
        return $this->lieuMission;
    }

    public function setLieuMission(string $lieuMission): static
    {
        $this->lieuMission = $lieuMission;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getUsers(): ?users
    {
        return $this->users;
    }

    public function setUsers(?users $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, skills>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(skills $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(skills $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
    }
}
