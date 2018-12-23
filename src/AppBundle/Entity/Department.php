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
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="topPageDesc", type="string", length=255)
     */
    private $topPageDesc;

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
     * Get staffMember
     *
     * @return string 
     */
    public function getStaffType()
    {
      $p = $this->getStaffMember()->toArray();

        $callouts_names = array('Superintendent', 'Chief', 'Executive Director on Assignment', 'Director, Human Capital Management Systems', 'Executive Director of Program Innovation and Student Well-Being', 'Director','Management Officer', 'General Counsel', 'Coordinator', 'Instructional Facilitator', 'Program Head', 'Manager - IT Partnerships', 'Manager Information Technology Business Services', 'Manager', 'Assistant Manager', 'Administrator', 'Executive Assistant', 'Secretary');

        $callouts_pos = array();
        // re-builds the array with everything from callouts_names first
        $ids = [];
        // becomes references to individual staff IDs from database

        foreach ($p as $index => $member) {
          // loops through and looks for if position title is on department page, takes values from $callouts_names array
          foreach ($callouts_names as $names) {
            if (strpos($member->getPosition(), $names) !== false) {
                // if, for instance, 'secretary' comes back from getPosition() then below block will not run. Block will run on titles not found on page and updates array $callout_pos with titles only found on page.
                if (!in_array($member->getId(), $ids)) {
                  $callouts_pos[$names][]=$member;
                  $ids[] = $member->getId();
                  // unset will remove any records matching titles in $callouts_pos array not found on page
                  unset($p[$index]);
                }
            }
          }
        }

        if (array_key_exists('Secretary', $callouts_pos)) {
          // title will be in $callouts_pos, runs foreach statement above then merges position reference into new array if found on page. If statements run in order of hierarchy, $callouts_names is order that staff records should show up on page.
          $p = array_merge($callouts_pos['Secretary'], $p);
        } 
        if (array_key_exists('Executive Assistant', $callouts_pos)) {
          $p = array_merge($callouts_pos['Executive Assistant'], $p);
        }
        if (array_key_exists('Administrator', $callouts_pos)) {
          $p = array_merge($callouts_pos['Administrator'], $p);
        }
        if (array_key_exists('Program Head', $callouts_pos)) {
          $p = array_merge($callouts_pos['Program Head'], $p);
        }
        if (array_key_exists('Instructional Facilitator', $callouts_pos)) {
          $p = array_merge($callouts_pos['Instructional Facilitator'], $p);
        }          
        if (array_key_exists('Coordinator', $callouts_pos)) {
          $p = array_merge($callouts_pos['Coordinator'], $p);
        }
        if (array_key_exists('Executive Director on Assignment', $callouts_pos)) {
          $p = array_merge($callouts_pos['Executive Director on Assignment'], $p);
        }
        if (array_key_exists('Assistant Manager', $callouts_pos)) {
          $p = array_merge($callouts_pos['Assistant Manager'], $p);
        } 
        if (array_key_exists('Director, Human Capital Management Systems', $callouts_pos)) {
          $p = array_merge($callouts_pos['Director, Human Capital Management Systems'], $p);
        }       
        if (array_key_exists('Manager - IT Partnerships', $callouts_pos)) {
          $p = array_merge($callouts_pos['Manager - IT Partnerships'], $p);
        }
        if (array_key_exists('Manager Information Technology Business Services', $callouts_pos)) {
          $p = array_merge($callouts_pos['Manager Information Technology Business Services'], $p);
        }         
        if (array_key_exists('Manager', $callouts_pos)) {
          $p = array_merge($callouts_pos['Manager'], $p);
        }          
        if (array_key_exists('General Counsel', $callouts_pos)) {
          $p = array_merge($callouts_pos['General Counsel'], $p);
        }
        if (array_key_exists('Management Officer', $callouts_pos)) {
          $p = array_merge($callouts_pos['Management Officer'], $p);
        }
        if (array_key_exists('Director', $callouts_pos)) {
          $p = array_merge($callouts_pos['Director'], $p);
        }
        if (array_key_exists('Executive Director of Program Innovation and Student Well-Being', $callouts_pos)) {
          $p = array_merge($callouts_pos['Executive Director of Program Innovation and Student Well-Being'], $p);
        }
        if (array_key_exists('Chief', $callouts_pos)) {
          $p = array_merge($callouts_pos['Chief'], $p);
        }
        if (array_key_exists('Superintendent', $callouts_pos)) {
          $p = array_merge($callouts_pos['Superintendent'], $p);
        }

      return $p;
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

    /**
     * Set location
     *
     * @param string $location
     * @return Department
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Department
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set topPageDesc
     *
     * @param string $topPageDesc
     * @return Department
     */
    public function setTopPageDesc($topPageDesc)
    {
        $this->topPageDesc = $topPageDesc;

        return $this;
    }

    /**
     * Get topPageDesc
     *
     * @return string 
     */
    public function getTopPageDesc()
    {
        return $this->topPageDesc;
    }
}
