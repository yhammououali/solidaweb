<?php

namespace Steria\SolidaClicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Steria\SolidaUserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="help_requests")
 * @ORM\Entity(repositoryClass="Steria\SolidaClicBundle\Repository\HelpRequestRepository")
 */
class HelpRequest
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created_at = new \DateTime(date('Y-m-d H:i:s'));
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
    /**
     * @ORM\Column(type="date", nullable=true))
     * @Assert\Date()
     */
	protected $solved;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=8, nullable=false)
     */
    protected $lat;
    
    /**
     * @ORM\Column(type="decimal", precision=11, scale=8, nullable=false)
     */
    protected $lon;
    
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $description;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $title;
	
    /**
     * @ORM\ManyToOne(targetEntity="Steria\SolidaUserBundle\Entity\User", cascade={"all"}, fetch="EAGER")
     */
    protected $fkUser;
    
    /**
     * @ORM\ManyToOne(targetEntity="Steria\SolidaClicBundle\Entity\Category", cascade={"all"}, fetch="EAGER")
     */
    protected $fkCateg;

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
     * Set solved
     *
     * @param \DateTime $solved
     * @return HelpRequest
     */
    public function setSolved($solved)
    {
        $this->solved = $solved;
    
        return $this;
    }

    /**
     * Get solved
     *
     * @return \DateTime 
     */
    public function getSolved()
    {
        return $this->solved;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return HelpRequest
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
     * @return HelpRequest
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
     * @return HelpRequest
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
     * Set fkCateg
     *
     * @param \Steria\SolidaClicBundle\Entity\Category $fkCateg
     * @return HelpRequest
     */
    public function setFkCateg(\Steria\SolidaClicBundle\Entity\Category $fkCateg = null)
    {
        $this->fkCateg = $fkCateg;
    
        return $this;
    }

    /**
     * Get fkCateg
     *
     * @return \Steria\SolidaClicBundle\Entity\Category 
     */
    public function getFkCateg()
    {
        return $this->fkCateg;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return HelpRequest
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
     * @return HelpRequest
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
     * @return HelpRequest
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

    /**
     * Set description
     *
     * @param string $description
     * @return HelpRequest
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
     * Set title
     *
     * @param string $title
     * @return HelpRequest
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return HelpRequest
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
