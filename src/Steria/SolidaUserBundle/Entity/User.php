<?php

namespace Steria\SolidaUserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * Private for internal use
     */
    private $genderFully = array("H" => "Homme", "F" => "Femme", "A" => "Autre");
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->fkHelpRequest = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFeedback = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=65)
     * @Assert\Regex(pattern="/^[a-zA-ZàâéêèëîïôûùüçÀÂÉÊÈËÎÏÔÛÙÜÇ -]+$/", message="Caractères non valides utilisés")
     * @Assert\Length(min="2", max="65")
     */
    protected $lastname;
    
    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\Choice(choices = {"H", "F", "A"}, message = "Choisissez un genre valide")
     */
    protected $gender;
    
    /**
     * @ORM\Column(type="string", length=65)
     * @Assert\Regex(pattern="/^[a-zA-ZàâéêèëîïôûùüçÀÂÉÊÈËÎÏÔÛÙÜÇ -]+$/", message="Caractères non valides utilisés")
     * @Assert\Length(min="2", max="65")
     */
    protected $firstname;
    
    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    protected $birthdate;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $reqid;
    
    /**
     * @ORM\OneToMany(targetEntity="\Steria\SolidaClicBundle\Entity\HelpRequest", mappedBy="id", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    protected $fkHelpRequest;
    
    /**
     * @ORM\OneToMany(targetEntity="\Steria\SolidaClicBundle\Entity\Feedback", mappedBy="id", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    protected $fkFeedback;

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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Add fkHelpRequest
     *
     * @param \Steria\SolidaClicBundle\Entity\HelpRequest $fkHelpRequest
     * @return User
     */
    public function addFkHelpRequest(\Steria\SolidaClicBundle\Entity\HelpRequest $fkHelpRequest)
    {
        $this->fkHelpRequest[] = $fkHelpRequest;
    
        return $this;
    }

    /**
     * Remove fkHelpRequest
     *
     * @param \Steria\SolidaClicBundle\Entity\HelpRequest $fkHelpRequest
     */
    public function removeFkHelpRequest(\Steria\SolidaClicBundle\Entity\HelpRequest $fkHelpRequest)
    {
        $this->fkHelpRequest->removeElement($fkHelpRequest);
    }

    /**
     * Get fkHelpRequest
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFkHelpRequest()
    {
        return $this->fkHelpRequest;
    }

    /**
     * Add fkFeedback
     *
     * @param \Steria\SolidaClicBundle\Entity\Feedback $fkFeedback
     * @return User
     */
    public function addFkFeedback(\Steria\SolidaClicBundle\Entity\Feedback $fkFeedback)
    {
        $this->fkFeedback[] = $fkFeedback;
    
        return $this;
    }

    /**
     * Remove fkFeedback
     *
     * @param \Steria\SolidaClicBundle\Entity\Feedback $fkFeedback
     */
    public function removeFkFeedback(\Steria\SolidaClicBundle\Entity\Feedback $fkFeedback)
    {
        $this->fkFeedback->removeElement($fkFeedback);
    }

    /**
     * Get fkFeedback
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFkFeedback()
    {
        return $this->fkFeedback;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get fully qualified gender
     *
     * @return string 
     */
    public function getFullyGender()
    {
        
        if (array_key_exists($this->gender, $this->genderFully))
            return $this->genderFully[$this->gender];
        
        return "Inconnu";
    }

    /**
     * Set reqid
     *
     * @param string $reqid
     * @return User
     */
    public function setReqid($reqid)
    {
        $this->reqid = $reqid;
    
        return $this;
    }

    /**
     * Get reqid
     *
     * @return string 
     */
    public function getReqid()
    {
        return $this->reqid;
    }
}
