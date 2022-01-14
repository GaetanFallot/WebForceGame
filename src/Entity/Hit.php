<?php

namespace App\Entity;

use App\Repository\HitRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HitRepository::class)]
class Hit
{

    const TYPE_CONTACT = 'contact';
    const TYPE_DISTANCE = 'distance';
    const TYPE_MAGIE = 'magie';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Combat::class, inversedBy: 'hits')]
    #[ORM\JoinColumn(nullable: false)]
    private $combat;

    #[ORM\ManyToOne(targetEntity: Characters::class, inversedBy: 'hits')]
    #[ORM\JoinColumn(name: '`character_id`', nullable: false)]
    private $character;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $damage;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCombat(): ?Combat
    {
        return $this->combat;
    }

    public function setCombat(?Combat $combat): self
    {
        $this->combat = $combat;

        return $this;
    }

    public function getCharacter(): ?Characters
    {
        return $this->character;
    }

    public function setCharacter(?Characters $character): self
    {
        $this->character = $character;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): self
    {
        $this->damage = $damage;

        return $this;
    }
}
