<?php

namespace App\Entity;

use App\Repository\ExerciseClassifierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints\CharacterLength;

/**
 * @ORM\Entity(repositoryClass=ExerciseClassifierRepository::class)
 */
class ExerciseClassifier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"main"})
     * @Assert\NotBlank
     * @CharacterLength(
     * min = 5,
     * minMessage = "Minimum length is 5."
     * )
     */
    private $name;

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
}
