<?php

namespace App\Entity;

use App\Entity\User\Practitioner;
use App\Repository\DegreeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DegreeRepository::class)
 */
class Degree
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
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Practitioner::class, inversedBy="degrees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $practitioner;

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Practitioner|null
     */
    public function getPractitioner(): ?Practitioner
    {
        return $this->practitioner;
    }

    /**
     * @param Practitioner|null $practitioner
     * @return $this
     */
    public function setPractitioner(?Practitioner $practitioner): self
    {
        $this->practitioner = $practitioner;

        return $this;
    }
}
