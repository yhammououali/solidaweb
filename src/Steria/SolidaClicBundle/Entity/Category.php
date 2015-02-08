<?php

namespace Steria\SolidaClicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
    */
	protected $description;
    
    /**
     * @ORM\OneToMany(targetEntity="\Steria\SolidaClicBundle\Entity\HelpRequest", mappedBy="id", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    protected $fkHelpRequest;

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
     * Set description
     *
     * @param string $description
     * @return Category
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
     * Set fkCateg
     *
     * @param \Steria\SolidaClicBundle\Entity\HelpRequest $fkCateg
     * @return Category
     */
    public function setFkHelpRequest(\Steria\SolidaClicBundle\Entity\HelpRequest $fkHelpRequest = null)
    {
        $this->fkHelpRequest = $fkHelpRequest;
    
        return $this;
    }

    /**
     * Get fkCateg
     *
     * @return \Steria\SolidaClicBundle\Entity\HelpRequest 
     */
    public function getFkHelpRequest()
    {
        return $this->fkHelpRequest;
    }
}
