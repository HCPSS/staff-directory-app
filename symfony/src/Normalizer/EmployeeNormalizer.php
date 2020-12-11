<?php

namespace App\Normalizer;

use App\Document\Employee;

class EmployeeNormalizer {
    public static function normalize(Employee $filter, bool $trim = true) {
        $normal = ['employee_id' => $filter->getId()];
            
        if ($filter->getFirstName() || !$trim) {
            $normal['first_name'] = $filter->getFirstName();
        }
        
        if ($filter->getLastName() || !$trim) {
            $normal['last_name'] = $filter->getLastName();
        }
                    
        if ($filter->getDisplayName() || !$trim) {
            $normal['display_name'] = $filter->getDisplayName();
        }
                    
        if ($filter->getEmail() || !$trim) {
            $normal['email'] = $filter->getEmail();
        }
        
        if ($filter->getPhone() || !$trim) {
            $normal['phone'] = $filter->getPhone();
        }
        
        return $normal;
    }
}
