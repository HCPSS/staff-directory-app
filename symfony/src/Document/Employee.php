<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Employee
{
    /**
     * @MongoDB\Id(strategy="NONE", type="string")
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $lastName;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $firstName;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $displayName;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $phone;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $email;
    
    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param mixed $id
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * @param mixed $lastName
     * @return self
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;
        
        return $this;
    }

    /**
     * @param mixed $firstName
     * @return self
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;
        
        return $this;
    }

    /**
     * @param mixed $displayName
     * @return self
     */
    public function setDisplayName($displayName): self
    {
        $this->displayName = $displayName;
        
        return $this;
    }

    /**
     * @param mixed $phone
     * @return self
     */
    public function setPhone($phone): self
    {
        $this->phone = $phone;
        
        return $this;
    }

    /**
     * @param mixed $email
     * @return self
     */
    public function setEmail($email): self
    {
        $this->email = $email;
        
        return $this;
    }
}
