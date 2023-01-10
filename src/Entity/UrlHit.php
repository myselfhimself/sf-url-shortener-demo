<?php

namespace App\Entity;

use App\Repository\UrlHitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrlHitRepository::class)]
class UrlHit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'urlHits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShortUrl $shortUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getShortUrl(): ?ShortUrl
    {
        return $this->shortUrl;
    }

    public function setShortUrl(?ShortUrl $shortUrl): self
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }
}