<?php

namespace App\Entity;

use App\Repository\TwitterUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TwitterUserRepository::class)]
class TwitterUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 63)]
    private $username;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createDateAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updateDateAt;

    #[ORM\OneToMany(mappedBy: 'twitterUser', targetEntity: TwitterUserFollows::class)]
    private $twitterUserFollows;

    public function __construct()
    {
        $this->twitterUserFollows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getCreateDateAt(): ?\DateTimeImmutable
    {
        return $this->createDateAt;
    }

    public function setCreateDateAt(\DateTimeImmutable $createDateAt): self
    {
        $this->createDateAt = $createDateAt;

        return $this;
    }

    public function getUpdateDateAt(): ?\DateTimeImmutable
    {
        return $this->updateDateAt;
    }

    public function setUpdateDateAt(?\DateTimeImmutable $updateDateAt): self
    {
        $this->updateDateAt = $updateDateAt;

        return $this;
    }

    /**
     * @return Collection<int, TwitterUserFollows>
     */
    public function getTwitterUserFollows(): Collection
    {
        return $this->twitterUserFollows;
    }

    public function addTwitterUserFollow(TwitterUserFollows $twitterUserFollow): self
    {
        if (!$this->twitterUserFollows->contains($twitterUserFollow)) {
            $this->twitterUserFollows[] = $twitterUserFollow;
            $twitterUserFollow->setTwitterUser($this);
        }

        return $this;
    }

    public function removeTwitterUserFollow(TwitterUserFollows $twitterUserFollow): self
    {
        if ($this->twitterUserFollows->removeElement($twitterUserFollow)) {
            // set the owning side to null (unless already changed)
            if ($twitterUserFollow->getTwitterUser() === $this) {
                $twitterUserFollow->setTwitterUser(null);
            }
        }

        return $this;
    }
}
