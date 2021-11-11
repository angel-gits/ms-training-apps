<?php

namespace App\Entity;

use App\Repository\GoalUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GoalUserRepository::class)
 */
class GoalUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $userId;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"main"})
     */
    private $idDone;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"main"})
     */
    private $criteria = array();

    /**
     * @ORM\ManyToOne(targetEntity=Goal::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"main"})
     */
    private $goal;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"main"})
     */
    private $cValues = array();

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"main"})
     */
    private $units = array();

    public function __construct($goal) {
        $this->idDone = false;
        $this->goal = $goal;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdDone(): ?bool
    {
        return $this->idDone;
    }

    public function setIdDone(bool $idDone): self
    {
        $this->idDone = $idDone;

        return $this;
    }

    public function getCriteria(): ?array
    {
        return $this->criteria;
    }

    public function setCriteria(?array $criteria): self
    {
        $this->criteria = $criteria;

        return $this;
    }

    public function getGoal(): ?Goal
    {
        return $this->goal;
    }

    public function setGoal(?Goal $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    public function getCValues(): ?array
    {
        return $this->cValues;
    }

    public function setCValues(?array $cValues): self
    {
        $this->cValues = $cValues;

        return $this;
    }

    public function getUnits(): ?array
    {
        return $this->units;
    }

    public function setUnits(?array $units): self
    {
        $this->units = $units;

        return $this;
    }
}
