<?php

namespace App\Entity;

use App\Repository\BidRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BidRepository::class)
 */
class Bid
{
    const TO_TRAINER = 0;
    const TO_USER = 1;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     * @Groups({"additional"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Groups({"additional_in"})
     * @Groups({"additional"})
     */
    private $senderId;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Groups({"additional_out"})
     * @Groups({"additional"})
     */
    private $recieverId;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"main"})
     * @Groups({"additional"})
     */
    private $type;

    public function __construct(int $senderId, int $recieverId, int $type)
    {
        $this->senderId = $senderId;
        $this->recieverId = $recieverId;
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSenderId(): ?int
    {
        return $this->senderId;
    }

    public function setSenderId(?int $senderId): self
    {
        $this->senderId = $senderId;

        return $this;
    }

    public function getRecieverId(): ?int
    {
        return $this->recieverId;
    }

    public function setRecieverId(?int $recieverId): self
    {
        $this->recieverId = $recieverId;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }
}
