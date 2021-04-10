<?php

namespace App\Entity\User;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\Appointment;
use App\Entity\Availability;
use App\Entity\Degree;
use App\Entity\Language;
use App\Entity\Locality;
use App\Entity\Speciality;
use App\Entity\User;
use App\Repository\PractitionerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Practitioner.
 *
 * @ApiResource(
 *      subresourceOperations={
 *       "availabilities_get_subresource"={
 *           "method"="GET",
 *           "normalization_context"={
 *               "groups"={"availability:read"}
 *           }
 *       }
 *      }
 * )
 * @ORM\Entity(repositoryClass=PractitionerRepository::class)
 */
class Practitioner extends User implements UserInterface
{
    /**
     * @ORM\ManyToMany(targetEntity=Language::class, inversedBy="practitioners")
     * @ORM\JoinTable(name="practitioners_languages",
     *      joinColumns={@ORM\JoinColumn(name="practitioner_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="language_id", referencedColumnName="id")}
     *  )
     */
    private $languages;

    /**
     * @ORM\ManyToMany(targetEntity=Speciality::class, mappedBy="practitioners")
     */
    private $specialities;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="practitioner")
     */
    private $appointments;

    /**
     * @ORM\OneToMany(targetEntity=Availability::class, mappedBy="practitioner", orphanRemoval=true)
     * @ApiSubresource()
     */
    private $availabilities;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Locality::class,
     *     mappedBy="practitioner",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     */
    private $localities;

    /**
     * @ORM\OneToMany(targetEntity=Degree::class,
     *     mappedBy="practitioner",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     *  )
     */
    private $degrees;

    /**
     * Practitioner constructor.
     */
    public function __construct()
    {
        $this->roles[] = 'ROLE_PRACTITIONER';
        $this->languages = new ArrayCollection();
        $this->specialities = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->availabilities = new ArrayCollection();
        $this->localities = new ArrayCollection();
        $this->degrees = new ArrayCollection();
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    /**
     * @param Language $language
     * @return $this
     */
    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    /**
     * @param Language $language
     * @return $this
     */
    public function removeLanguage(Language $language): self
    {
        $this->languages->removeElement($language);

        return $this;
    }

    /**
     * @return Collection|Speciality[]
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    /**
     * @param Speciality $speciality
     * @return $this
     */
    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities[] = $speciality;
            $speciality->addPractitioner($this);
        }

        return $this;
    }

    /**
     * @param Speciality $speciality
     * @return $this
     */
    public function removeSpeciality(Speciality $speciality): self
    {
        if ($this->specialities->removeElement($speciality)) {
            $speciality->removePractitioner($this);
        }

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    /**
     * @param Appointment $appointment
     * @return $this
     */
    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setPractitioner($this);
        }

        return $this;
    }

    /**
     * @param Appointment $appointment
     * @return $this
     */
    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getPractitioner() === $this) {
                $appointment->setPractitioner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Availability[]
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    /**
     * @param Availability $availability
     * @return $this
     */
    public function addAvailability(Availability $availability): self
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities[] = $availability;
            $availability->setPractitioner($this);
        }

        return $this;
    }

    /**
     * @param Availability $availability
     * @return $this
     */
    public function removeAvailability(Availability $availability): self
    {
        if ($this->availabilities->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getPractitioner() === $this) {
                $availability->setPractitioner(null);
            }
        }

        return $this;
    }

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
     * @return Collection|Locality[]
     */
    public function getLocalities(): Collection
    {
        return $this->localities;
    }

    /**
     * @param Locality $locality
     * @return $this
     */
    public function addLocality(Locality $locality): self
    {
        if (!$this->localities->contains($locality)) {
            $this->localities[] = $locality;
            $locality->setPractitioner($this);
        }

        return $this;
    }

    /**
     * @param Locality $locality
     * @return $this
     */
    public function removeLocality(Locality $locality): self
    {
        if ($this->localities->removeElement($locality)) {
            // set the owning side to null (unless already changed)
            if ($locality->getPractitioner() === $this) {
                $locality->setPractitioner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Degree[]
     */
    public function getDegrees(): Collection
    {
        return $this->degrees;
    }

    /**
     * @param Degree $degree
     * @return $this
     */
    public function addDegree(Degree $degree): self
    {
        if (!$this->degrees->contains($degree)) {
            $this->degrees[] = $degree;
            $degree->setPractitioner($this);
        }

        return $this;
    }

    /**
     * @param Degree $degree
     * @return $this
     */
    public function removeDegree(Degree $degree): self
    {
        if ($this->degrees->removeElement($degree)) {
            // set the owning side to null (unless already changed)
            if ($degree->getPractitioner() === $this) {
                $degree->setPractitioner(null);
            }
        }

        return $this;
    }
}
