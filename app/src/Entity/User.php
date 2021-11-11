<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"main"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $trainersId;

    /**
     * @ORM\Column(type="array")
     */
    private $usersId;

    public function __construct(int $id, ?string $email, array $roles) {
        $this->id = $id;
        $this->email = $email;
        $this->roles = $roles;

        $this->registrationDate = new \DateTime('now');

        $this->trainersId = array();
        $this->usersId = array();

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|int[]
     */
    public function gettrainersId()
    {
        return $this->trainersId;
    }

    public function addTrainerId(int $trainerId): self
    {
        if (!in_array($trainerId, $this->trainersId)) {
            $this->trainersId[] = $trainerId;
        }

        return $this;
    }

    public function removeTrainerId(int $trainerId): self
    {
        $this->trainersId = \array_diff($this->trainersId, [$trainerId]);

        return $this;
    }

    /**
     * @return Collection|int[]
     */
    public function getusersId()
    {
        return $this->usersId;
    }

    public function addUserId(int $userId): self
    {
        if (!in_array($userId, $this->usersId)) {
            $this->usersId[] = $userId;
        }

        return $this;
    }

    public function removeUserId(int $userId): self
    {
        $this->usersId = \array_diff($this->usersId, [$userId]);

        return $this;
    }

    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
    }
}
