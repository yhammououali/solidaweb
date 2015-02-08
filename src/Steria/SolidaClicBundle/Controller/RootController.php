<?php

namespace Steria\SolidaClicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

/**
 * @Route("/")
 */
class RootController extends Controller
{
    /**
     * @Route("/")
     * @Template("SteriaSolidaClicBundle:Root:index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/legal")
     * @Template("SteriaSolidaClicBundle:Root:legal.html.twig")
     */
    public function legalAction()
    {
        return array();
    }
    
    /**
     * @Route("/contact")
     * @Template("SteriaSolidaClicBundle:Root:contact.html.twig")
     */
    public function contactAction()
    {
        $sended = false;
    
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $subject = $request->request->get('inpSubject');
            $mail = $request->request->get('inpEmail');
            $nodemande = $request->request->get('inpDemande');
            $nom = $request->request->get('inpNom');
            $phone = $request->request->get('inpPhone');
            $msg = $request->request->get('inpMessage');
            
            $emailConstraint = new EmailConstraint();
            $emailConstraint->message = 'Your customized error message';
            $emailErrors = $this->get('validator')->validateValue($mail, $emailConstraint);
            
            if (count($emailErrors) == 0) {
                $message = \Swift_Message::newInstance();
                $message->setSubject($subject);
                $message->setFrom($mail);
                $message->setTo('support@solidaclic.com');
                $message->setBody(
                            $this->renderView(
                                'SteriaSolidaClicBundle:Mail:support.txt.twig',
                                array(
                                    'nodemande' => $nodemande,
                                    'nom' => $nom,
                                    'phone' => $phone,
                                    'message' => $msg,
                                    'mail' => $mail,
                                    'subject' => $subject,
                                )
                            )
                );
                
                $this->get('mailer')->send($message);
                $sended = true;
            }
        }
        
        return array(
            'sended' => $sended,
        );
    }
}
