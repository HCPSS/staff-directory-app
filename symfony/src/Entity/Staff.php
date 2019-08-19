<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StaffRepository")
 */
class Staff implements CardableInterface
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $displayName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Department", inversedBy="staff")
     */
    private $departments;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="staff")
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $employeeId;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Entity\CardableInterface::getCardType()
     */
    public function getCardType() : string
    {
        return 'person';
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
     * Get the first name.
     * 
     * @return string|NULL
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set the first name.
     * 
     * @param string $firstName
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get last name.
     * 
     * @return string|NULL
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set the last name.
     * 
     * @param string $lastName
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the display name.
     * 
     * @return string|NULL
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * Set the display name.
     * 
     * @param string $displayName
     * @return self
     */
    public function setDisplayName(?string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get the position.
     * 
     * @return string|NULL
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * Set the position.
     * 
     * @param string $position
     * @return self
     */
    public function setPosition(string $position): self
    {
        $this->position = $position;

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
        }

        return $this;
    }

    /**
     * Get the phone number.
     * 
     * @return string|NULL
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set the phone number.
     * 
     * @param string $phone
     * @return self
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get email.
     * 
     * @return string|NULL
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the email.
     * 
     * @param string $email
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the location.
     * 
     * @return Location|NULL
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * Set the location.
     * 
     * @param Location $location
     * @return self
     */
    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the employee id.
     * 
     * @return string|NULL
     */
    public function getEmployeeId(): ?string
    {
        return $this->employeeId;
    }

    /**
     * Set the employee id.
     * 
     * @param string $employeeId
     * @return self
     */
    public function setEmployeeId(string $employeeId): self
    {
        $this->employeeId = $employeeId;

        return $this;
    }
    
    /**
     * Get the weight of the staff member based on position.
     * 
     * @return int
     */
    public function getWeight() : int
    {
        $hierarchy = [
            'Superintendent' => -40,
            'Chief' => -35,
            'Director' => -30,
            'Manager' => -25,
            'General Counsel' => -20,
            'Coordinator' => -15,
            'Officer' => -10,
            'Instructional Facilitator' => -5,
            'Administrator' => 5,
        ];
        
        $weight = 99;
        
        foreach ($hierarchy as $keyPhrase => $w) {
            if (strpos($this->position, $keyPhrase) !== false) {
                $weight = $w;
                break;
            }
        }
        
        $modifiers = [
            'Assistant' => 1,
            'Acting' => 1,
        ];
        
        foreach ($modifiers as $modifier => $value) {
            if (strpos($this->position, $modifier) !== false) {
                $weight += $value;
            }
        }
        
        return $weight;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getDisplayName();
    }
}
