<?php

namespace App\Entity;

use App\Repository\CharactersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['name'], message: 'Un personnage existe déjà avec cet nom')]
#[ORM\Entity(repositoryClass: CharactersRepository::class)]
class Characters
{

    const ABILITIES_COEFF = 3;
    const VITALITY_COEFF = 5;

    const IMAGE_DIRECTORY = "/image/character";

    const MAX_TOTAL_ABILITIES = 5;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Assert\NotBlank]
    private $name;
    
    #[ORM\Column(type: 'string', length: 255)]
    // #[Assert\NotBlank] J'arrive pas à obliger une image ici
    private $image;

    #[ORM\Column(type: 'integer')]
    private ?int $hp_max = 50;

    #[ORM\Column(type: 'integer')]
    private $hp ;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $str = 0;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $con = 0;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $dex = 0;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $intel = 0 ;

    #[ORM\Column(type: 'integer')]
    private int $level = 1;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $status = 'alive';

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Profession::class, inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private $profession;



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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }


    public function getImageSrc(): ?string
    {
        return self::IMAGE_DIRECTORY.$this->image;
    }


    public function getHpMax(): ?int
    {
        return  $this->getCon()*self::VITALITY_COEFF+$this->hp_max;
    }

    public function setHpMax(int $hp_max): self
    {
        $this->hp_max = $hp_max;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $this->getHpMax();

        return $this;
    }

    public function getStr(): ?int
    {
        return $this->str;
    }

    public function setStr(int $str): self
    {
        $this->str = $str;

        return $this;
    }

    public function getCon(): ?int
    {
        return $this->con;
    }

    public function setCon(int $con): self
    {
        $this->con = $con;

        return $this;
    }

    public function getDex(): ?int
    {
        return $this->dex;
    }

    public function setDex(int $dex): self
    {
        $this->dex = $dex;

        return $this;
    }

    public function getIntel(): ?int
    {
        return $this->intel;
    }

    public function setIntel(int $intel): self
    {
        $this->intel = $intel;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

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


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProfession(): ?Profession
    {
        return $this->profession;
    }

    public function setProfession(?Profession $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getAttContact(): int
    {
        return $this->str*self::ABILITIES_COEFF;
    }

    public function getAttDistance(): int
    {
        return $this->dex*self::ABILITIES_COEFF;
    }

    public function getAttMagie(): int
    {
        return $this->intel*self::ABILITIES_COEFF;
    }

    #[Assert\EqualTo(value: self::MAX_TOTAL_ABILITIES,)]
    public function getTotalAbilities(): int
    {
        
        return $this->getStr()+$this->getCon()+$this->getDex()+$this->getIntel();
    }
}
