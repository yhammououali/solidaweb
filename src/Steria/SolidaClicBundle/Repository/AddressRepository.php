<?php

namespace Steria\SolidaClicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AddressRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AddressRepository extends EntityRepository
{
	public function getByCoord($lat=null, $lon=null, $dist=null)
	{
		$qb = $this->_em->createQueryBuilder();
		
        $qb->select("adr");
		$qb->from('SteriaSolidaClicBundle:Address', 'adr');
		
        $qb->where('GEO(adr.lat = :latitude, adr.lon = :longitude) <= :dist');
        $qb->setParameter('latitude', $lat);
        $qb->setParameter('longitude', $lon);
		$qb->setParameter('dist', $dist);
		
		return $qb->getQuery()->getResult();
	}
}