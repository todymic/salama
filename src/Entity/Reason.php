<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReasonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ReasonRepository::class)
 */
class Reason
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $constant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Speciality::class, inversedBy="reasons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getConstant(): ?string
    {
        return $this->constant;
    }

    /**
     * @param string $constant
     * @return $this
     */
    public function setConstant(string $constant): self
    {
        $this->constant = $constant;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Speciality|null
     */
    public function getCategory(): ?Speciality
    {
        return $this->category;
    }

    /**
     * @param Speciality|null $category
     * @return $this
     */
    public function setCategory(?Speciality $category): self
    {
        $this->category = $category;

        return $this;
    }
}
