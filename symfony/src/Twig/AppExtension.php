<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     * @see \Twig\Extension\AbstractExtension::getFilters()
     */
    public function getFilters()
    {
        return [
            new TwigFilter('phone', [$this, 'formatPhone'])
        ];
    }
    
    /**
     * Format a phone number.
     * 
     * @param string $phone
     * @return string
     */
    public function formatPhone($phone)
    {
        $lineNumber = substr($phone, -4);
        $prefix = substr($phone, -7, 3);
        $areaCode = substr($phone, -10, 3);
        
        return "($areaCode) $prefix-$lineNumber";
    }
}
