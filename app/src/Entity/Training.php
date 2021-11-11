<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TrainingRepository::class)
 */
class Training
{
    const PLANNED = 0;
    const IN_PROGRESS = 1;
    const FINISHED = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TrainingPlan::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     * @Groups({"main"})
     */
    private $trainingPlan;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime(format=\DateTime::ISO8601)
     * @var \DateTime
     * @Groups({"main"})
     */
    private $startDateTime;

    /**
     * @ORM\ManyToOne(targetEntity=Program::class, inversedBy="trainings")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $program;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime(format=\DateTime::ISO8601)
     * @var \DateTime
     * @Groups({"main"})
     */
    private $finishDateTime;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"main"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Exercise::class, mappedBy="training", orphanRemoval=true)
     * @Groups({"additional_training"})
     */
    private $exercises;

    /**
     * @ORM\ManyToOne(targetEntity=GoalUser::class)
     * @Groups({"main"})
     */
    private $goal;

    public function __construct($trainingPlan, $program)
    {
        $this->exercises = new ArrayCollection();
        $this->status = self::PLANNED;
        $this->trainingPlan = $trainingPlan;
        $this->program = $program;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainingPlan(): ?TrainingPlan
    {
        return $this->trainingPlan;
    }

    public function setTrainingPlan(?TrainingPlan $trainingPlan): self
    {
        $this->trainingPlan = $trainingPlan;

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

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Exercise[]
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises[] = $exercise;
            $exercise->setTraining($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercises->removeElement($exercise)) {
            // set the owning side to null (unless already changed)
            if ($exercise->getTraining() === $this) {
                $exercise->setTraining(null);
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
