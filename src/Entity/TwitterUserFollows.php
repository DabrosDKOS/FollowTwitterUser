<?php

namespace App\Entity;

use App\Repository\TwitterUserFollowsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TwitterUserFollowsRepository::class)]
class TwitterUserFollows
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TwitterUser::class, inversedBy: 'twitterUserFollows')]
    private $twitterUser;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createDateAt;

    #[ORM\Column(type: 'string', length: 11)]
    private $follow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTwitterUser(): ?TwitterUser
    {
        return $this->twitterUser;
    }

    public function setTwitterUser(?TwitterUser $twitterUser): self
    {
        $this->twitterUser = $twitterUser;

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

    public function getFollow(): ?string
    {
        return $this->follow;
    }

    public function setFollow(string $follow): self
    {
        $this->follow = $follow;

        return $this;
    }
}
