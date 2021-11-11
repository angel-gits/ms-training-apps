<?php

namespace App\Entity;

use App\Repository\ExercisePlanRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ExercisePlanRepository::class)
 */
class ExercisePlan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TrainingPlan::class, inversedBy="plannedExercises")
     * @ORM\JoinColumn(nullable=true)
     */
    private $trainingPlan;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     * @Assert\NotNull
     * @Assert\Type("integer")
     */
    private $setsNum;

    /**
     * @ORM\ManyToOne(targetEntity=Goal::class)
     * @Groups({"main_g"})
     */
    private $goal;

    /**
     * @ORM\ManyToOne(targetEntity=ExerciseClassifier::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     * @Groups({"main"})
     */
    private $name;

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

    public function getSetsNum(): ?int
    {
        return $this->setsNum;
    }

    public function setSetsNum($setsNum): self
    {
        $this->setsNum = $setsNum;

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

    public function getName(): ?ExerciseClassifier
    {
        return $this->name;
    }

    public function setName(?ExerciseClassifier $name): self
    {
        $this->name = $name;

        return $this;
    }
}
