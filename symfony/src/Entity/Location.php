<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressStreet1;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $zip;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Department", mappedBy="location")
     */
    private $departments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Staff", mappedBy="location")
     */
    private $staff;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $longitude;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->staff = new ArrayCollection();
    }

    /**
     * Get the id.
     * 
     * @return int|NULL
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get name.
     * 
     * @return string|NULL
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name.
     * 
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get address street 1.
     * 
     * @return string|NULL
     */
    public function getAddressStreet1(): ?string
    {
        return $this->addressStreet1;
    }

    /**
     * Set the street address 1.
     * 
     * @param string $addressStreet1
     * @return self
     */
    public function setAddressStreet1(string $addressStreet1): self
    {
        $this->addressStreet1 = $addressStreet1;

        return $this;
    }

    /**
     * Get the city.
     * 
     * @return string|NULL
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set the city.
     * 
     * @param string $city
     * @return self
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the state.
     * 
     * @return string|NULL
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Set the state.
     * 
     * @param string $state
     * @return self
     */
    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the zip code.
     * 
     * @return string|NULL
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * Set the zip code.
     * 
     * @param string $zip
     * @return self
     */
    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get departments.
     * 
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    /**
     * Add a department.
     * 
     * @param Department $department
     * @return self
     */
    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
            $department->setLocation($this);
        }

        return $this;
    }

    /**
     * Remove a department.
     * 
     * @param Department $department
     * @return self
     */
    public function removeDepartment(Department $department): self
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
            // set the owning side to null (unless already changed)
            if ($department->getLocation() === $this) {
                $department->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * Get the staff.
     * 
     * @return Collection|Staff[]
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    /**
     * Add a staff member.
     * 
     * @param Staff $staff
     * @return self
     */
    public function addStaff(Staff $staff): self
    {
        if (!$this->staff->contains($staff)) {
            $this->staff[] = $staff;
            $staff->setLocation($this);
        }

        return $this;
    }

    /**
     * Remove a staff member.
     * 
     * @param Staff $staff
     * @return self
     */
    public function removeStaff(Staff $staff): self
    {
        if ($this->staff->contains($staff)) {
            $this->staff->removeElement($staff);
            // set the owning side to null (unless already changed)
            if ($staff->getLocation() === $this) {
                $staff->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * Get latitude.
     * 
     * @return string|NULL
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * Set the latitude.
     * 
     * @param string $latitude
     * @return self
     */
    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get longitude.
     * 
     * @return string|NULL
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * Set longitude.
     * 
     * @param string $longitude
     * @return self
     */
    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
    
    /**
     * Get the full address.
     * 
     * @return string|NULL
     */
    public function getAddress() : ?string
    {
        return vsprintf('%s, %s, %s, %s', [
            $this->addressStreet1,
            $this->city,
            $this->state,
            $this->zip,
        ]);
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
