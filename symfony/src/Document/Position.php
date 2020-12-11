<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Position
{
    /**
     * @MongoDB\Id(strategy="NONE", type="string")
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $description;
    
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
    public function getDescription(): ?string
    {
        return $this->description;
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
     * @param mixed $description
     * @return self
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        
        return $this;
    }
}
