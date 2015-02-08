<?php

namespace Steria\SolidaClicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/login")
	 * @Method("POST")
     */
    public function loginAction()
    {
		$em = $this->getDoctrine()->getManager();
		$repuser = $em->getRepository('SteriaSolidaUserBundle:User');
		$request = $this->get('request');
		
		if ($request->getMethod() == 'POST') {
			$p_username = $request->request->get('username');
			$p_password = $request->request->get('password');
			$p_regid    = $request->request->get('regId');
			
			$oneuser = $repuser->findOneByUsername($p_username);
			
			if ($oneuser !== null) {
				// user found
				
				$encoder = $this->get('security.encoder_factory')->getEncoder($oneuser);
				$encodedPass = $encoder->encodePassword($p_password, $oneuser->getSalt());
				if ($oneuser->getPassword() === $encodedPass) {
					// password ok
					
					$oneuser->setReqid($p_regid);
					$em->persist($oneuser);
					$em->flush();
				}
				else {
					// bad password
				}
			}
			else {
				// user does not exist
			}
		}
		
		return new Response();
	}
}
