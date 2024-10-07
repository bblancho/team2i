<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\InheritanceType("JOINED")] // ou "SINGLE_TABLE" Mise e place de l'héritage pour les tables clients / Sociétés
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')] // heritage
#[ORM\DiscriminatorMap(['societes' => Societes::class, 'clients' => Clients::class])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: "Cet email est déjà utilisé.")]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank()]  // Interdit les valeurs vides, rajoute l'attribut required
    #[Assert\Email(
        message: "Cet adresse {{ value }}, n'est pas une email valid.",
    )]
    private string $email ;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]  // Interdit les valeurs vides, rajoute l'attribut required
    #[Assert\Length(
        min: 8,
        max: 100,
        minMessage: "Le mot de passe doit faire minimum {{ limit }} caractères.",
    )]
    #[Assert\Regex(
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,}$/",
        message: "Le mot de passe est incorrect."
    )]
    private string $password ;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()] // Interdit les valeurs vides , rajoute l'attribut required
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit faire minimum {{ limit }} caractères.",
        maxMessage: "Le nom doit faire au maximum {{ limit }} caractères."
    )]
    private string $nom = " " ; 

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()] // Interdit les valeurs vides , rajoute l'attribut required
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "L'adresse doit faire minimum  {{ limit }} caractères .",
        maxMessage: "L'adresse doit faire au maximum  {{ limit }} caractères .",
    )]
    private string $adresse = " " ; 

    #[ORM\Column]
    #[Assert\NotBlank()] // Interdit les valeurs vides , rajoute l'attribut required
    #[Assert\Length(
        min: 5,
        max: 5,
        minMessage: "Le code postal doit faire minimum  {{ limit }} caractères .",
        maxMessage: "Le code postal doit faire au maximum  {{ limit }} caractères .",
    )]
    private int $cp ; 

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()] // Interdit les valeurs vides , rajoute l'attribut required
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "La ville doit faire minimum  {{ limit }} caractères .",
        maxMessage: "La ville doit faire au maximum  {{ limit }} caractères .",
    )]
    private string $ville = " ";

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank()]
    private string $phone = " ";

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    private string $typeUser = " "; 

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateInscriptionAt ;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()] 
    #[Assert\Length(
        min: 8,
        max: 12,
        minMessage: "Le numéro de siret doit faire au minimum  {{ limit }} caractères .",
        maxMessage: "Le numéro de siret doit faire au maximum  {{ limit }} caractères .",
    )]
    private string $siret = " ";

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $isVerified = false;

    #[ORM\Column(nullable: true)]
    #[Assert\NotNull]
    private ?bool $isNewsletter = false;

    // N'est pas enregistré dans la BDD
    private $plainPassword;

    /**
     * @var Collection<int, Skills>
     */
    #[ORM\OneToMany(targetEntity: Skills::class, mappedBy: 'users', orphanRemoval: true)]
    private Collection $skills;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastLonginAt = null;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
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
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

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

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): int
    {
        return $this->cp;
    }

    public function setCp(int $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getTypeUser(): string
    {
        return $this->typeUser;
    }

    public function setTypeUser(string $typeUser): static
    {
        $this->typeUser = $typeUser;

        return $this;
    }

    public function getDateInscriptionAt(): ?\DateTimeImmutable
    {
        return $this->dateInscriptionAt;
    }

    public function setDateInscriptionAt(?\DateTimeImmutable $dateInscriptionAt): static
    {
        $this->dateInscriptionAt = $dateInscriptionAt;

        return $this;
    }

    public function getSiret(): string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getIsNewsletter(): ?bool
    {
        return $this->isNewsletter;
    }

    public function setIsNewsletter(string $isNewsletter): static
    {
        $this->isNewsletter = $isNewsletter;

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

    public function getLastLonginAt(): ?\DateTimeImmutable
    {
        return $this->lastLonginAt;
    }

    public function setLastLonginAt(?\DateTimeImmutable $lastLonginAt): static
    {
        $this->lastLonginAt = $lastLonginAt;

        return $this;
    }

}
