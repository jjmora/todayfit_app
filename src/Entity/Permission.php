<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[ApiResource(
  collectionOperations: ['get'],
  itemOperations: ['get'],
)]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
      message: 'Le Nom ne peux pas être vide',
    )]
    #[Assert\Length(
      min: 3,
      max: 50,
      minMessage: 'Le Nom doit avoir au moins {{ limit }} caractères',
      maxMessage: 'Le Nom doit avoir au maximum {{ limit }} caractères',
    )]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Franchise::class, mappedBy: 'permissions')]
    private Collection $franchises;

    #[ORM\ManyToMany(targetEntity: Partner::class, mappedBy: 'permissions')]
    private Collection $partners;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(
      message: "La valeur n'est pas une URL valide",
    )]
    private ?string $image = null;

    public function __construct()
    {
        $this->franchises = new ArrayCollection();
        $this->partners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Franchise>
     */
    public function getFranchises(): Collection
    {
        return $this->franchises;
    }

    public function addFranchise(Franchise $franchise): self
    {
        if (!$this->franchises->contains($franchise)) {
            $this->franchises->add($franchise);
            $franchise->addPermission($this);
        }

        return $this;
    }

    public function removeFranchise(Franchise $franchise): self
    {
        if ($this->franchises->removeElement($franchise)) {
            $franchise->removePermission($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Partner>
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    public function addPartner(Partner $partner): self
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
            $partner->addPermission($this);
        }

        return $this;
    }

    public function removePartner(Partner $partner): self
    {
        if ($this->partners->removeElement($partner)) {
            $partner->removePermission($this);
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
