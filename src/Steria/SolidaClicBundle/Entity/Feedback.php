<?php

namespace Steria\SolidaClicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Steria\SolidaUserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="feedbacks")
 */
class Feedback
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Steria\SolidaUserBundle\Entity\User", cascade={"all"}, fetch="EAGER")
     */
    protected $fkUser;
    
    /**
     * @ORM\ManyToOne(targetEntity="HelpRequest", cascade={"all"}, fetch="EAGER")
     */
    protected $fkHelpRequest;
    
    protected $score;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $comment;

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
     * Set date
     *
     * @param \DateTime $date
     * @return Feedback
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Feedback
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set fkUser
     *
     * @param \Steria\SolidaUserBundle\Entity\User $fkUser
     * @return Feedback
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
     * Set fkHelpRequest
     *
     * @param \Steria\SolidaClicBundle\Entity\HelpRequest $fkHelpRequest
     * @return Feedback
     */
    public function setFkHelpRequest(\Steria\SolidaClicBundle\Entity\HelpRequest $fkHelpRequest = null)
    {
        $this->fkHelpRequest = $fkHelpRequest;
    
        return $this;
    }

    /**
     * Get fkHelpRequest
     *
     * @return \Steria\SolidaClicBundle\Entity\HelpRequest 
     */
    public function getFkHelpRequest()
    {
        return $this->fkHelpRequest;
    }
}
