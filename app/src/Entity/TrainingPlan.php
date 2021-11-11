<?php

namespace App\Entity;

use App\Repository\TrainingPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TrainingPlanRepository::class)
 */
class TrainingPlan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProgramPlan::class, inversedBy="plannedTrainings")
     * @Groups({"additional_find"})
     */
    private $programPlan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"main"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Goal::class)
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"main_t"})
     */
    private $goal;

    /**
     * @ORM\OneToMany(targetEntity=ExercisePlan::class, mappedBy="trainingPlan", orphanRemoval=true)
     * @Groups({"additional_tp"})
     */
    private $plannedExercises;

    public function __construct()
    {
        $this->plannedExercises = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection|ExercisePlan[]
     */
    public function getPlannedExercises(): Collection
    {
        return $this->plannedExercises;
    }

    public function addPlannedExercise(ExercisePlan $plannedExercise): self
    {
        if (!$this->plannedExercises->contains($plannedExercise)) {
            $this->plannedExercises[] = $plannedExercise;
            $plannedExercise->setTrainingPlan($this);
        }

        return $this;
    }

    public function removePlannedExercise(ExercisePlan $plannedExercise): self
    {
        if ($this->plannedExercises->removeElement($plannedExercise)) {
            // set the owning side to null (unless already changed)
            if ($plannedExercise->getTrainingPlan() === $this) {
                $plannedExercise->setTrainingPlan(null);
            }
        }

        return $this;
    }
}
