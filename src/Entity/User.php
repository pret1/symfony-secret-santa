<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('user_read')]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups('user_read')]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups('user_read')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups('user_read')]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'users', fetch: 'EXTRA_LAZY')]
    #[Groups('user_read')]
    private Collection $groupsUsers;

    #[ORM\OneToMany(mappedBy: 'mainAuthor', targetEntity: Group::class)]
    #[Groups('user_read')]
    private Collection $mainGroups;

    public function __construct()
    {
        $this->groupsUsers = new ArrayCollection();
        $this->mainGroups = new ArrayCollection();
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
    public function getUserIdentifier(): string
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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
     * @return Collection<int, Group>
     */
    public function getGroupsUsers(): Collection
    {
        return $this->groupsUsers;
    }

    public function addGroupsUser(Group $groupsUser): self
    {
        if (!$this->groupsUsers->contains($groupsUser)) {
            $this->groupsUsers->add($groupsUser);
            $groupsUser->addUser($this);
        }

        return $this;
    }

    public function removeGroupsUser(Group $groupsUser): self
    {
        if ($this->groupsUsers->removeElement($groupsUser)) {
            $groupsUser->removeUser($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getMainGroups(): Collection
    {
        return $this->mainGroups;
    }

    public function addMainGroup(Group $mainGroup): self
    {
        if (!$this->mainGroups->contains($mainGroup)) {
            $this->mainGroups->add($mainGroup);
            $mainGroup->setMainAuthor($this);
        }

        return $this;
    }

    public function removeMainGroup(Group $mainGroup): self
    {
        if ($this->mainGroups->removeElement($mainGroup)) {
            // set the owning side to null (unless already changed)
            if ($mainGroup->getMainAuthor() === $this) {
                $mainGroup->setMainAuthor(null);
            }
        }

        return $this;
    }
}
