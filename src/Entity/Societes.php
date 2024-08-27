<?php

namespace App\Entity;

use App\Entity\Users;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SocietesRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocietesRepository::class)]
#[Vich\Uploadable]
class Societes extends Users
{

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit faire minimum {{ limit }} caractères.",
        maxMessage: "Le nom doit faire au maximum {{ limit }} caractères."
    )]
    private ?string $nomContact = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $numContact = null;

    #[Vich\UploadableField(mapping: 'clients', fileNameProperty: 'imageName')]
    #[Assert\Image()]
    private ?File $imageFile = null;

    #[ORM\Column( length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le secteur d'activité doit faire minimum  {{ limit }} caractères .",
        maxMessage: "Le secteur d'activité doit faire au maximum  {{ limit }} caractères .",
    )]
    private ?string $secteurActivite = null;

    public function getNomContact(): ?string
    {
        return $this->nomContact;
    }

    public function setNomContact(?string $nomContact): static
    {
        $this->nomContact = $nomContact;

        return $this;
    }

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phoneContact = null;

    /**
     * @var Collection<int, Missions>
     */
    #[ORM\OneToMany(targetEntity: Missions::class, mappedBy: 'societes', orphanRemoval: true)]
    private Collection $missions;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
    }

    public function getNumContact(): ?string
    {
        return $this->numContact;
    }

    public function setNumContact(?string $numContact): static
    {
        $this->numContact = $numContact;

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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        // if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
        //     $this->updatedAt = new \DateTimeImmutable();
        // }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

    public function getPhoneContact(): ?string
    {
        return $this->phoneContact;
    }

    public function setPhoneContact(?string $phoneContact): static
    {
        $this->phoneContact = $phoneContact;

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
            $mission->setSocietes($this);
        }

        return $this;
    }

    public function removeMission(Missions $mission): static
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getSocietes() === $this) {
                $mission->setSocietes(null);
            }
        }

        return $this;
    }


}