<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * StaffRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StaffRepository extends EntityRepository
{
	public function findAllOrderedByName($searchTerm) {
		return $this->getEntityManager()
    ->createQuery(
        "SELECT staff 
        FROM AppBundle:Staff staff 
        WHERE staff.firstName LIKE '%$searchTerm%' OR staff.lastName LIKE '%$searchTerm%'
        ORDER BY staff.lastName ASC"
    )
    ->getResult();
	}

	public function findDeptOrderedByNameOnce() {
		return $this->getEntityManager()
    ->createQuery(
        'SELECT a.department 
        FROM AppBundle:Staff a
        GROUP BY a.department'
    )
    ->getResult();
	}
}
