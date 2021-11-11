<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProgramRepository::class)
 */
class Program
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProgramPlan::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     * @Groups({"main"})
     */
    private $programPlan;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     * @Groups({"main"})
     */
    private $ownerId;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"main"})
     */
    private $trainersId = array();

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     * @Assert\DateTime(format=\DateTime::ISO8601)
     * @var \DateTime
     * @Groups({"main"})
     */
    private $startDateTime;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     * @Assert\DateTime(format=\DateTime::ISO8601)
     * @var \DateTime
     * @Groups({"main"})
     */
    private $finishDateTime;

    /**
     * @ORM\OneToMany(targetEntity=Training::class, mappedBy="program", orphanRemoval=true)
     * @Groups({"additional_program"})
     */
    private $trainings;

    /**
     * @ORM\ManyToOne(targetEntity=GoalUser::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     * @Groups({"main"})
     */
    private $goal;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramPlan(): ?ProgramPlan
    {
        return $this->programPlan;
    }

    public function setProgramPlan(?ProgramPlan $programPlan): self
    {
        $this->programPlan = $programPlan;

        return $this;
    }

    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getTrainersId(): ?array
    {
        return $this->trainersId;
    }

    public function setTrainersId(?array $trainersId): self
    {
        $this->trainersId = $trainersId;

        return $this;
    }

    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    public function setStartDateTime($startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getFinishDateTime()
    {
        return $this->finishDateTime;
    }

    public function setFinishDateTime($finishDateTime): self
    {
        $this->finishDateTime = $finishDateTime;

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->setProgram($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getProgram() === $this) {
                $training->setProgram(null);
            }
        }

        return $this;
    }

    public function getGoal(): ?GoalUser
    {
        return $this->goal;
    }

    public function setGoal(?GoalUser $goal): self
    {
        $this->goal = $goal;

        return $this;
    }
}
