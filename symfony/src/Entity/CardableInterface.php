<?php

namespace App\Entity;

interface CardableInterface
{
    /**
     * Get the card type.
     * 
     * @return string
     */
    public function getCardType() : string;    
}
