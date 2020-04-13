<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
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
    private $id;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Assert\Range(min=0, max=20, invalidMessage="value must be between 0 and 20")
     * @Assert\NotNull
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="decimal",
     *             "example"=15.5
     *         }
     *     }
     * )
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="string",
     *             "example"="Music"
     *         }
     *     }
     * )
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="note")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    public $student;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }
}
