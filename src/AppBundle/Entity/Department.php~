<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    // ...

    /**
     * @ORM\OneToMany(targetEntity="Staff", mappedBy="department")
     */
    private $staffMember;

    public function __construct()
    {
        $this->staffMember = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Department
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add staffMember
     *
     * @param \AppBundle\Entity\Staff $staffMember
     * @return Department
     */
    public function addStaffMember(\AppBundle\Entity\Staff $staffMember)
    {
        $this->staffMember[] = $staffMember;

        return $this;
    }

    /**
     * Remove staffMember
     *
     * @param \AppBundle\Entity\Staff $staffMember
     */
    public function removeStaffMember(\AppBundle\Entity\Staff $staffMember)
    {
        $this->staffMember->removeElement($staffMember);
    }

    /**
     * Get staffMember
     *
     * @return string 
     */
    public function getStaffMember()
    {
        return $this->staffMember;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Department
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Department
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
