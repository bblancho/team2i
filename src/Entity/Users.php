<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $cp = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(length: 50)]
    private ?string $typeUser = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomContact  = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phoneContact = null;

    #[ORM\Column(nullable: true)]
    private ?bool $dispo = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateDispoAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $tjm = null;

    #[ORM\Column(length: 255)]
    private ?string $siret = null;

    #[ORM\Column]
    private ?bool $isVerified = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $secteurActivite = null;

    #[ORM\Column(length: 255)]
    private ?string $feauturedImage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isNewsletter = null;

    /**
     * @var Collection<int, Missions>
     */
    #[ORM\OneToMany(targetEntity: Missions::class, mappedBy: 'users', orphanRemoval: true)]
    private Collection $missions;

    /**
     * @var Collection<int, Skills>
     */
    #[ORM\OneToMany(targetEntity: Skills::class, mappedBy: 'users', orphanRemoval: true)]
    private Collection $skills;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getTypeUser(): ?string
    {
        return $this->typeUser;
    }

    public function setTypeUser(string $typeUser): static
    {
        $this->typeUser = $typeUser;

        return $this;
    }

    public function getNomContact(): ?string
    {
        return $this->nomContact;
    }

    public function setNomContact(?string $nomContact): static
    {
        $this->nomContact = $nomContact;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoneContact(): ?string
    {
        return $this->phoneContact;
    }

    public function setPhoneContact(?string $phoneContact): static
    {
        $this->phoneContact = $phoneContact;

        return $this;
    }

    public function isDispo(): ?bool
    {
        return $this->dispo;
    }

    public function setDispo(?bool $dispo): static
    {
        $this->dispo = $dispo;

        return $this;
    }

    public function getDateDispoAt(): ?\DateTimeImmutable
    {
        return $this->dateDispoAt;
    }

    public function setDateDispoAt(?\DateTimeImmutable $dateDispoAt): static
    {
        $this->dateDispoAt = $dateDispoAt;

        return $this;
    }

    public function getTjm(): ?int
    {
        return $this->tjm;
    }

    public function setTjm(?int $tjm): static
    {
        $this->tjm = $tjm;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getSecteurActivite(): ?string
    {
        return $this->secteurActivite;
    }

    public function setSecteurActivite(?string $secteurActivite): static
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    public function getFeauturedImage(): ?string
    {
        return $this->feauturedImage;
    }

    public function setFeauturedImage(string $feauturedImage): static
    {
        $this->feauturedImage = $feauturedImage;

        return $this;
    }

    public function isNewsletter(): ?bool
    {
        return $this->isNewsletter;
    }

    public function setNewsletter(?bool $isNewsletter): static
    {
        $this->isNewsletter = $isNewsletter;

        return $this;
    }

    /**
     * @return Collection<int, Missions>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Missions $mission): static
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->setUsers($this);
        }

        return $this;
    }

    public function removeMission(Missions $mission): static
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getUsers() === $this) {
                $mission->setUsers(null);
            }
        }

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
            $skill->setUsers($this);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getUsers() === $this) {
                $skill->setUsers(null);
            }
        }

        return $this;
    }
}
