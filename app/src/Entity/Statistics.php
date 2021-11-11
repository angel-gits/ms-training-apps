<?php

namespace App\Entity;

use App\Repository\StatisticsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StatisticsRepository::class)
 */
class Statistics
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"additional"})
     */
    private $exersiceName;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"main"})
     */
    private $date;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"main"})
     */
    private $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"main"})
     */
    private $time;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"main"})
     */
    private $repetitionNum;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    public function __construct($exerciseName, $date, $weight, $time, $repetitionNum, $userId) {
        $this->exersiceName = $exerciseName;
        $this->date = $date;
        $this->weight = $weight;
        $this->time = $time;
        $this->repetitionNum = $repetitionNum;
        $this->userId = $userId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExersiceName(): ?string
    {
        return $this->exersiceName;
    }

    public function setExersiceName(string $exersiceName): self
    {
        $this->exersiceName = $exersiceName;

        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(?int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getRepetitionNum(): ?int
    {
        return $this->repetitionNum;
    }

    public function setRepetitionNum(?int $repetitionNum): self
    {
        $this->repetitionNum = $repetitionNum;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
