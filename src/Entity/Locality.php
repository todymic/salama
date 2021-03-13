<?php

namespace App\Entity;

use App\Entity\User\Practitioner;
use App\Repository\LocalityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocalityRepository::class)
 */
class Locality
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
    private $streetType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $streetName;

    /**
     * @ORM\Column(type="integer")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="integer")
     */
    private $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity=Practitioner::class, inversedBy="localities")
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
    public function getStreetType(): ?string
    {
        return $this->streetType;
    }

    /**
     * @param string $streetType
     * @return $this
     */
    public function setStreetType(string $streetType): self
    {
        $this->streetType = $streetType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    /**
     * @param string $streetName
     * @return $this
     */
    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    /**
     * @param int $zipcode
     * @return $this
     */
    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    /**
     * @param int $streetNumber
     * @return $this
     */
    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

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
