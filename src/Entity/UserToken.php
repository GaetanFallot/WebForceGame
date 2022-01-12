<?php

namespace App\Entity;

use App\Repository\UserTokenRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


#[ORM\Entity(repositoryClass: UserTokenRepository::class)]
class UserToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'userToken', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private $user;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\Column(type: 'datetime_immutable')]
    private $expires_at;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $used_at;


    public function __construct()
    {
        $this->token = Uuid::v6();
    }

    public function isValid(): bool
    {
        return $this->expires_at > new DatetimeImmutable()
            && $this->used_at === null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expires_at;
    }

    public function setExpiresAt(\DateTimeImmutable $expires_at): self
    {
        $this->expires_at = $expires_at;

        return $this;
    }

    public function getUsedAt(): ?\DateTimeImmutable
    {
        return $this->used_at;
    }

    public function setUsedAt(\DateTimeImmutable $used_at): self
    {
        $this->used_at = $used_at;

        return $this;
    }
}
