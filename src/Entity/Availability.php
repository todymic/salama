<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\Practitioner;
use App\Repository\AvailabilityRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"availability:read"}},
 * )
 * @ORM\Entity(repositoryClass=AvailabilityRepository::class)
 */
class Availability
{
    public const OPEN = 'OPEN';
    public const BUSY = 'BUSY';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("availability:read")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups("availability:read")
     */
    private $day;

    /**
     * @ORM\Column(type="time")
     */
    private $hour;

    /**
     * @ORM\Column(type="string", length=255, columnDefinition="ENUM('OPEN','BUSY')")
     * @Groups("availability:read")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Practitioner::class, inversedBy="availabilities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $practitioner;

    /**
     * @ORM\OneToOne(targetEntity=Appointment::class, mappedBy="availability", cascade={"persist", "remove"})
     * @Groups("availability:read")
     */
    private $appointment;

    /**
     * @ORM\ManyToOne(targetEntity=Locality::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("availability:read")
     */
    private $locality;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?DateTimeInterface
    {
        return $this->day;
    }

    /**
     * @param DateTimeInterface $day
     * @return $this
     */
    public function setDay(DateTimeInterface $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getHour(): ?DateTimeInterface
    {
        return $this->hour;
    }

    /**
     * @param DateTimeInterface $hour
     * @return $this
     */
    public function setHour(DateTimeInterface $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

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

    public function getAppointment(): ?Appointment
    {
        return $this->appointment;
    }

    /**
     * @param Appointment $appointment
     * @return $this
     */
    public function setAppointment(Appointment $appointment): self
    {
        // set the owning side of the relation if necessary
        if ($appointment->getAvailability() !== $this) {
            $appointment->setAvailability($this);
        }

        $this->appointment = $appointment;

        return $this;
    }

    public function getLocality(): ?Locality
    {
        return $this->locality;
    }

    /**
     * @param Locality|null $locality
     * @return $this
     */
    public function setLocality(?Locality $locality): self
    {
        $this->locality = $locality;

        return $this;
    }
}
