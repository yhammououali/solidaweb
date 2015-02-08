<?php

namespace Steria\SolidaClicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Steria\SolidaUserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Steria\SolidaClicBundle\Repository\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    protected $placename;
    
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[0-9a-zA-ZàâéêèëîïôûùüçÀÂÉÊÈËÎÏÔÛÙÜÇ ',\/\.°&#()*:-]+$/")
     */
    protected $address;
    
    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[0-9a-zA-Z]+$/")
     */
    protected $zip;
    
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[a-zA-ZàâéêèëîïôûùüçÀÂÉÊÈËÎÏÔÛÙÜÇ '-]+$/")
     */
    protected $city;
	
    /**
     * @ORM\ManyToOne(targetEntity="Steria\SolidaUserBundle\Entity\User", cascade={"all"}, fetch="EAGER")
     */
    protected $fkUser;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=8, nullable=false)
     */
    protected $lat;
    
    /**
     * @ORM\Column(type="decimal", precision=11, scale=8, nullable=false)
     */
    protected $lon;

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
     * Set lat
     *
     * @param string $lat
     * @return Address
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    
        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param string $lon
     * @return Address
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
    
        return $this;
    }

    /**
     * Get lon
     *
     * @return string 
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Set fkUser
     *
     * @param \Steria\SolidaUserBundle\Entity\User $fkUser
     * @return Address
     */
    public function setFkUser(\Steria\SolidaUserBundle\Entity\User $fkUser = null)
    {
        $this->fkUser = $fkUser;
    
        return $this;
    }

    /**
     * Get fkUser
     *
     * @return \Steria\SolidaUserBundle\Entity\User 
     */
    public function getFkUser()
    {
        return $this->fkUser;
    }

    /**
     * Set placename
     *
     * @param string $placename
     * @return Address
     */
    public function setPlacename($placename)
    {
        $this->placename = $placename;
    
        return $this;
    }

    /**
     * Get placename
     *
     * @return string 
     */
    public function getPlacename()
    {
        return $this->placename;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Address
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    
        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }
}
