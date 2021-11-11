<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ExerciseRepository::class)
 */
class Exercise
{
    const PLANNED = 0;
    const IN_PROGESS = 1;
    const FINISHED = 2;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ExercisePlan::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"main"})
     */
    private $exercisePlan;

    /**
     * @ORM\ManyToOne(targetEntity=Training::class, inversedBy="exercises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $training;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type("float")
     * @Groups({"main"})
     */
    private $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     * @Groups({"main"})
     */
    private $repetitionNum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     * @Groups({"main"})
     */
    private $timeLimit;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"main"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=GoalUser::class)
     * @Groups({"main"})
     */
    private $goal;

    public function __construct($exercisePlan, $training) {
        $this->status = self::PLANNED;
        $this->exercisePlan = $exercisePlan;
        $this->training = $training;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercisePlan(): ?ExercisePlan
    {
        return $this->exercisePlan;
    }

    public function setExercisePlan(?ExercisePlan $exercisePlan): self
    {
        $this->exercisePlan = $exercisePlan;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight($weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getRepetitionNum(): ?int
    {
        return $this->repetitionNum;
    }

    public function setRepetitionNum($repetitionNum): self
    {
        $this->repetitionNum = $repetitionNum;

        return $this;
    }

    public function getTimeLimit(): ?int
    {
        return $this->timeLimit;
    }

    public function setTimeLimit($timeLimit): self
    {
        $this->timeLimit = $timeLimit;

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
