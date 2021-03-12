<?php

namespace App\Entity\User;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Appointment;
use App\Entity\Language;
use App\Entity\Speciality;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Practitioner
 *
 * @package App\Entity\User
 * @ApiResource()
 * @ORM\Entity()
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

    public function __construct()
    {
        $this->roles[] = 'ROLE_PRACTITIONER';
        $this->languages = new ArrayCollection();
        $this->specialities = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

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

    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities[] = $speciality;
            $speciality->addPractitioner($this);
        }

        return $this;
    }

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

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setPractitioner($this);
        }

        return $this;
    }

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
}
