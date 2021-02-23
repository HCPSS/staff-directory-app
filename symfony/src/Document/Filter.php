<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Filter
{
    /**
     * @MongoDB\Id(strategy="NONE", type="string")
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="hash")
     */
    protected $document;
    
    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
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
     * @return array|NULL
     */
    public function getDocument(): ?array
    {
        return $this->document;
    }
    
    /**
     * @param array $document
     * @return self
     */
    public function setDocument(array $document): self
    {
        $this->document = $document;
        
        return $this;
    }
}
