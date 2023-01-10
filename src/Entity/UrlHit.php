<?php

namespace App\Entity;

use App\Repository\UrlHitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrlHitRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UrlHit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'urlHits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShortUrl $shortUrl = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
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