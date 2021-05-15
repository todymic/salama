<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\User\Practitioner;
use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *   subresourceOperations={
 *       "practitioners_get_subresource"={
 *           "method"="GET",
 *           "normalization_context"={
 *               "groups"={"practitioner:read"}
 *           }
 *       },
 *     "reasons_get_subresource"={
 *           "method"="GET",
 *           "normalization_context"={
 *               "groups"={"reason:read"}
 *           }
 *       },
 *   }
 * )
 * @ORM\Entity(repositoryClass=SpecialityRepository::class)
 */
class Speciality
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ApiSubresource()
     * @ORM\ManyToMany(targetEntity=Practitioner::class, inversedBy="specialities")
     * @ORM\JoinTable(name="practitioners_specialities",
     *      joinColumns={@ORM\JoinColumn(name="speciality_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="practitioner_id", referencedColumnName="id")}
     * )
     *
     */
    private $practitioners;

    /**
     * @ORM\OneToMany(targetEntity=Reason::class,
     *     mappedBy="category",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"})
     * @ApiSubresource()
     */
    private $reasons;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * Speciality constructor.
     */
    public function __construct()
    {
        $this->practitioners = new ArrayCollection();
        $this->reasons = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Practitioner[]
     */
    public function getPractitioners(): Collection
    {
        return $this->practitioners;
    }

    /**
     * @param Practitioner $practitioner
     * @return $this
     */
    public function addPractitioner(Practitioner $practitioner): self
    {
        if (!$this->practitioners->contains($practitioner)) {
            $this->practitioners[] = $practitioner;
        }

        return $this;
    }

    /**
     * @param Practitioner $practitioner
     * @return $this
     */
    public function removePractitioner(Practitioner $practitioner): self
    {
        $this->practitioners->removeElement($practitioner);

        return $this;
    }

    /**
     * @return Collection|Reason[]
     */
    public function getReasons(): Collection
    {
        return $this->reasons;
    }

    /**
     * @param Reason $reason
     * @return $this
     */
    public function addReason(Reason $reason): self
    {
        if (!$this->reasons->contains($reason)) {
            $this->reasons[] = $reason;
            $reason->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Reason $reason
     * @return $this
     */
    public function removeReason(Reason $reason): self
    {
        if ($this->reasons->removeElement($reason)) {
            // set the owning side to null (unless already changed)
            if ($reason->getCategory() === $this) {
                $reason->setCategory(null);
            }
        }

        return $this;
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
}
