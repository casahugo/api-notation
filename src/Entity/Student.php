<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(routePrefix="/students")
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="integer",
     *             "example"=1
     *         }
     *     }
     * )
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="string",
     *             "example"="Smith"
     *         }
     *     }
     * )
     */
    private ?string $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="string",
     *             "example"="John"
     *         }
     *     }
     * )
     */
    private ?string $firstname;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotNull
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="string",
     *             "example"="1990-10-10"
     *         }
     *     }
     * )
     */
    private ?\DateTimeInterface $birthday;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="student", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private Collection $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function saveNote(Note $note): self
    {
        $note->student = $this;
        $this->notes[] = $note;

        return $this;
    }

    public function getNotes(): ?Collection
    {
        return $this->notes;
    }
}
