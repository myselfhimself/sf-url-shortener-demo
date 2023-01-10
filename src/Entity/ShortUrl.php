<?php

namespace App\Entity;

use App\Repository\ShortUrlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShortUrlRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ShortUrl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $originalUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $shortUri = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'shortUrl', targetEntity: UrlHit::class)]
    private Collection $urlHits;

    public function __construct()
    {
        $this->urlHits = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalUrl(): ?string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): self
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getShortUri(): ?string
    {
        return $this->shortUri;
    }

    public function setShortUri(string $shortUri): self
    {
        $this->shortUri = $shortUri;

        return $this;
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

    /**
     * @return Collection<int, UrlHit>
     */
    public function getUrlHits(): Collection
    {
        return $this->urlHits;
    }

    public function addUrlHit(UrlHit $urlHit): self
    {
        if (!$this->urlHits->contains($urlHit)) {
            $this->urlHits->add($urlHit);
            $urlHit->setShortUrl($this);
        }

        return $this;
    }

    public function removeUrlHit(UrlHit $urlHit): self
    {
        if ($this->urlHits->removeElement($urlHit)) {
            // set the owning side to null (unless already changed)
            if ($urlHit->getShortUrl() === $this) {
                $urlHit->setShortUrl(null);
            }
        }

        return $this;
    }
}
