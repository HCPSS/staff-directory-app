<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department implements CardableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Department")
     */
    private $relatedDepartments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="departments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff", mappedBy="departments")
     */
    private $staff;
    
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
    

    public function __construct()
    {
        $this->relatedDepartments = new ArrayCollection();
        $this->staff = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     * @see \App\Entity\CardableInterface::getCardType()
     */
    public function getCardType() : string
    {
        return 'department';
    }
    
    /**
     * Get id.
     * 
     * @return int|NULL
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the name.
     * 
     * @return string|NULL
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Se the name.
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
     * Get the description.
     * 
     * @return string|NULL
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the description.
     * 
     * @param string $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
     * @return Collection|self[]
     */
    public function getRelatedDepartments(): Collection
    {
        return $this->relatedDepartments;
    }

    /**
     * Add a related department.
     * 
     * @param self $relatedDepartment
     * @return self
     */
    public function addRelatedDepartment(self $relatedDepartment): self
    {
        if (!$this->relatedDepartments->contains($relatedDepartment)) {
            $this->relatedDepartments[] = $relatedDepartment;
        }

        return $this;
    }

    /**
     * Remove a related department.
     * 
     * @param self $relatedDepartment
     * @return self
     */
    public function removeRelatedDepartment(self $relatedDepartment): self
    {
        if ($this->relatedDepartments->contains($relatedDepartment)) {
            $this->relatedDepartments->removeElement($relatedDepartment);
        }

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
     * @return Collection|Staff[]
     */
    public function getStaff(): Collection
    {
        $iterator = $this->staff->getIterator();
        $iterator->uasort(function ($a, $b) {
            if ($a->getWeight() == $b->getWeight()) {
                return ($a->getLastName() < $b->getLastName()) ? -1 : 1;
            }
            
            return ($a->getWeight() < $b->getWeight()) ? -1 : 1;
        });
        
        $members = new ArrayCollection(iterator_to_array($iterator));
        
        return $members;
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
            $staff->addDepartment($this);
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
            $staff->removeDepartment($this);
        }

        return $this;
    }
    
    /**
     * Get the slug.
     * 
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
