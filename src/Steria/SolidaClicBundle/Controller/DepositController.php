<?php

namespace Steria\SolidaClicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Steria\SolidaClicBundle\Entity\HelpRequest;

use Steria\SolidaClicBundle\Form\DepositType;

/**
 * @Route("/deposit")
 */
class DepositController extends Controller
{
    /**
     * @Route("/")
     * @Secure(roles="ROLE_USER")
     * @Template("SteriaSolidaClicBundle:Deposit:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sended = false;
        
        $repcatg = $em->getRepository('SteriaSolidaClicBundle:Category');
        $user = $this->get('security.context')->getToken()->getUser();
        $translator = $this->get('translator');
        
        /* début formulaire et traitement */
        $helprequest = new HelpRequest;
        
        $form = $this->createForm(new DepositType, $helprequest);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            $helprequest->setFkUser($user);
            
            $thiscateg = $repcatg->findOneById($request->request->get('inpCateg'));
            $googlecoord = $this->container->get('steria_solida_clic.googlemap');
            $coords = $googlecoord->addressToCoord($helprequest->getAddress(), $helprequest->getCity(), $helprequest->getZip());
            
            if ($thiscateg !== null && $coords !== null && $form->isValid()) {
                $helprequest->setFkCateg($thiscateg);
                $helprequest->setLat($coords['latitude']);
                $helprequest->setLon($coords['longitude']);
                
                $em->persist($helprequest);
                $em->flush();
                
                // go,go,go envoit des mails
                $repaddr = $em->getRepository('SteriaSolidaClicBundle:Address');
                $addresses = $repaddr->getByCoord($coords['latitude'], $coords['longitude'], 20);
                $already_send = array();
				
				$gcm = $this->container->get('steria_solida_clic.googlecloudmessage');
				$registatoin_ids = array();
				$gcmmessage = array("price" => $helprequest->getId());
                
                foreach ($addresses as $thisaddr) {
                    
                    if (!in_array($thisaddr->getFkUser(), $already_send)) {
                        $message = \Swift_Message::newInstance();
                        $message->setSubject($translator->trans("Annonce a votre portée"));
                        $message->setFrom("annonce@solidaclic.com");
                        $message->setTo($thisaddr->getFkUser()->getEmail());
                        $message->setBody(
                                    $this->renderView(
                                        'SteriaSolidaClicBundle:Mail:demande.txt.twig',
                                        array(
                                            'fulldemande' => $helprequest,
                                            'address' => $thisaddr,
                                        )
                                    )
                        );
                    
                        $this->get('mailer')->send($message);
						
						if ($thisaddr->getFkUser()->getReqid() != null) {
							$registatoin_ids[] = $thisaddr->getFkUser()->getReqid();
						}
						
                        $already_send[] = $thisaddr->getFkUser();
                    }
                }
				
				$gcm->send_push_notification($registatoin_ids, $gcmmessage);
                
                $sended = true;
                $form = $this->createForm(new DepositType, new HelpRequest);
            }
            else {
                if ($thiscateg === null) {
                    $this->get('session')->getFlashBag()->add('danger', $translator->trans('Catégorie invalide.'));
                }
                if ($coords === null) {
                    $this->get('session')->getFlashBag()->add('danger', $translator->trans('Adresse invalide.'));
                }
                if ($form->isValid()) {
                    $this->get('session')->getFlashBag()->add('danger', $translator->trans('Formulaire invalide.'));
                }
            }
        }
        /* fin formulaire et traitement */
        $allcatg = $repcatg->findAll();
        
        // envoit des informations à la vue
        return array(
                'form'      => $form->createView(),
                'catvalues' => $allcatg,
                'sended'    => $sended,
        );
    }
}
