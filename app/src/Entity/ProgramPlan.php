<?php

namespace App\Entity;

use App\Repository\ProgramPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProgramPlanRepository::class)
 */
class ProgramPlan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"main"})
     */
    private $name;

    /**
     * @ORM\Column(type="array")
     * @Groups({"main"})
     */
    private $authorsId = [];

    /**
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     * @Assert\Type("integer")
     * @Assert\NotNull
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity=Goal::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"main_pp"})
     */
    private $goal;

    /**
     * @ORM\OneToMany(targetEntity=TrainingPlan::class, mappedBy="programPlan")
     * @Groups({"additional"})
     */
    private $plannedTrainings;

    /**
     * @ORM\Column(type="array")
     * @Groups({"additional_author"})
     */
    private $ownersId = [];

    public function __construct(?int $duration, $name = null)
    {
        $this->plannedTrainings = new ArrayCollection();

        $this->name = $name;
        $this->duration = $duration;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthorsId(): ?array
    {
        return $this->authorsId;
    }

    public function setAuthorsId(array $authorsId): self
    {
        $this->authorsId = $authorsId;

        return $this;
    }

    public function removeAuthorId($authorId) {
        $this->authorsId = \array_diff($this->authorsId, [$authorId]);

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        $this->duration = $duration;

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
     * @return Collection|TrainingPlan[]
     */
    public function getPlannedTrainings(): Collection
    {
        return $this->plannedTrainings;
    }

    public function addPlannedTraining(TrainingPlan $plannedTraining): self
    {
        if (!$this->plannedTrainings->contains($plannedTraining)) {
            $this->plannedTrainings[] = $plannedTraining;
            $plannedTraining->setProgramPlan($this);
        }

        return $this;
    }

    public function removePlannedTraining(TrainingPlan $plannedTraining): self
    {
        if ($this->plannedTrainings->removeElement($plannedTraining)) {
            // set the owning side to null (unless already changed)
            if ($plannedTraining->getProgramPlan() === $this) {
                $plannedTraining->setProgramPlan(null);
            }
        }

        return $this;
    }

    public function getOwnersId(): ?array
    {
        return $this->ownersId;
    }

    public function setOwnersId(array $ownersId): self
    {
        $this->ownersId = $ownersId;

        return $this;
    }

    public function addOwnerId(int $ownerId): self {
        if(!in_array($ownerId, $this->ownersId))
            $this->ownersId[] = $ownerId;

        return $this;
    }
}
