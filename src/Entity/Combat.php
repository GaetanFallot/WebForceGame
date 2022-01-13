<?php

namespace App\Entity;

use App\Repository\CombatRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CombatRepository::class)]
class Combat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $date_combat = null;

    #[ORM\ManyToMany(targetEntity: characters::class, inversedBy: 'combats')]
    private $characters;

    #[ORM\ManyToOne(targetEntity: characters::class, inversedBy: 'combatsWon')]
    #[ORM\JoinColumn(nullable: true)]
    private $vainqueur;



    public function __construct()
    {
        $this->id_vainqueur = new ArrayCollection();
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCombat(): ?DateTimeImmutable
    {
        return $this->date_combat;
    }

    public function setDateCombat(DateTimeImmutable $date_combat): self
    {
        $this->date_combat = $date_combat;

        return $this;
    }

    /**
     * @return Collection|characters[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(characters $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
        }

        return $this;
    }

    public function removeCharacter(characters $character): self
    {
        $this->characters->removeElement($character);

        return $this;
    }

    public function getVainqueur(): ?characters
    {
        return $this->vainqueur;
    }

    public function setVainqueur(?characters $vainqueur): self
    {
        $this->vainqueur = $vainqueur;

        return $this;
    }


}
