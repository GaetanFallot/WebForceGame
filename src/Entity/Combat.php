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


    const FIGHT_PENDING = "pending";
    const FIGHT_IN_PROGRESS = "in progress";
    const FIGHT_END = "end";

    const FIGHT_REFUSED = "refused";

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

    #[ORM\Column(type: 'string', length: 255)]
    private $status = self::FIGHT_PENDING;

    #[ORM\ManyToOne(targetEntity: Characters::class, inversedBy: 'challengerCombats')]
    #[ORM\JoinColumn(nullable: false)]
    private $challenger;

    #[ORM\OneToMany(mappedBy: 'combat', targetEntity: Hit::class, orphanRemoval: true)]
    private $hits;



    public function __construct()
    {
        $this->id_vainqueur = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->hits = new ArrayCollection();
    }

    public function getCharacterByUser(User $user): ?Characters
    {
        foreach ($this->getCharacters() as $character) {
            if ($character->getUser() === $user) {
                return $character;
            }
        }
        return null;
    }

    public function getOpponent(Characters $character): ?Characters
    {
        foreach ($this->getCharacters() as $c) {
            if ($c !== $character) {
                return $c;
            }
        }

        return null;
    }

    public function getOutsider(): Characters
    {
        return $this->getOpponent($this->getChallenger());
    }

    public function getLastHitter(): ?Characters
    {
        /** @var Hit $lastHit */
        $lastHit = $this->getHits()->last();
        if ($lastHit) {
            return $lastHit->getCharacter();
        }
        return null;
    }

    public function getNextHitter(): Characters
    {
        if ($lastHitter = $this->getLastHitter()) {
            return $this->getOpponent($lastHitter);
        }

        return $this->getOutsider();
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getChallenger(): ?Characters
    {
        return $this->challenger;
    }

    public function setChallenger(?Characters $challenger): self
    {
        $this->challenger = $challenger;

        return $this;
    }

    /**
     * @return Collection|Hit[]
     */
    public function getHits(): Collection
    {
        return $this->hits;
    }

    public function addHit(Hit $hit): self
    {
        if (!$this->hits->contains($hit)) {
            $this->hits[] = $hit;
            $hit->setCombat($this);
        }

        return $this;
    }

    public function removeHit(Hit $hit): self
    {
        if ($this->hits->removeElement($hit)) {
            // set the owning side to null (unless already changed)
            if ($hit->getCombat() === $this) {
                $hit->setCombat(null);
            }
        }

        return $this;
    }


}
