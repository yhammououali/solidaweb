<?php

namespace Steria\SolidaClicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/scores")
 */
class ScoresController extends Controller
{
    /**
     * @Route("/")
     * @Template("SteriaSolidaClicBundle:Scores:index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/user/{id}", requirements={"id" = "\d+"}, defaults={"id" = 0})
     * @Template("SteriaSolidaClicBundle:Scores:user.html.twig")
     */
    public function userAction($id)
    {
		if ($id == 0) {
			$id = 0;
		}
		
        return array();
    }
}
