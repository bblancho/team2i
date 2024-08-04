<?php

namespace App\Entity;

use App\Entity\Users;
use App\Entity\Skills;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MissionsRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Missions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit faire minimum {{ limit }} caractères.",
        maxMessage: "Le nom doit faire au maximum {{ limit }} caractères."
    )]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        minMessage: "Le nom doit faire minimum {{ limit }} caractères.",
    )]
    private ?string $description = null;

    #[ORM\Column(length: 100)]
    // #[Assert\NotBlank()]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank()]
    private ?int $tarif = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $startDateAT = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $duree = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $lieuMission = null;

    #[ORM\Column]
    private ?bool $isActive = false;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    private ?int $experience = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $profil = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    private ?int $nbPersonnes = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $users = null;

    /**
     * @var Collection<int, Skills>
     */
    #[ORM\ManyToMany(targetEntity: Skills::class, inversedBy: 'missions')]
    private Collection $skills;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contraintes = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $refMission = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->startDateAT = new \DateTimeImmutable();
    }

    #[ORM\PrePersist()]
    public function prePresist(){
        $this->slug = (new Slugify())->slugify($this->nom) ;
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
        $this->slug = (new Slugify())->slugify($slug) ;

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

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

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

    public function setIsActive(bool $isActive): static
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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Skills>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(?string $profil): static
    {
        $this->profil = $profil;

        return $this;
    }

    public function getNbPersonnes(): ?int
    {
        return $this->nbPersonnes;
    }

    public function setNbPersonnes(int $nbPersonnes): static
    {
        $this->nbPersonnes = $nbPersonnes;

        return $this;
    }

    public function getContraintes(): ?string
    {
        return $this->contraintes;
    }

    public function setContraintes(?string $contraintes): static
    {
        $this->contraintes = $contraintes;

        return $this;
    }

    public function getRefMission(): ?string
    {
        return $this->refMission;
    }

    public function setRefMission(?string $refMission): static
    {
        $this->refMission = $refMission;

        return $this;
    }

 

}
