<?php

namespace Steria\SolidaClicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Security\Core\Util\StringUtils;

use Steria\SolidaClicBundle\Entity\Address;
use Steria\SolidaClicBundle\Form\AddressType;

use Steria\SolidaClicBundle\Service\GoogleMap;

/**
 * @Route("/account")
 */
class AccountController extends Controller
{
    /**
     * @Route("/")
     * @Secure(roles="ROLE_USER")
     * @Template("SteriaSolidaClicBundle:Account:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $allfeedbacks = $em->getRepository('SteriaSolidaClicBundle:Feedback')
                                ->findByFkUser($user)
        ;
        
        return array(
            "user"    =>    $user,
            "allfeedbacks" => $allfeedbacks,
        );
    }
    
    /**
     * @Route("/request")
     * @Secure(roles="ROLE_USER")
     * @Template("SteriaSolidaClicBundle:Account:request.html.twig")
     */
    public function requestAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $reprequst = $em->getRepository('SteriaSolidaClicBundle:HelpRequest');
        $allrequests = $reprequst->findByFkUser($user);

        return array(
            "allrequests" => $allrequests,
        );
    }
    
    /**
     * @Route("/request/delete/{id}", requirements={"id" = "\d+"})
     * @Secure(roles="ROLE_USER")
     */
    public function requestDeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $reprequst = $em->getRepository('SteriaSolidaClicBundle:HelpRequest');
        $onerequest = $reprequst->findOneById($id);
        
        if ($onerequest->getFkUser() == $user) {
            $onerequest->setSolved(new \DateTime(date('Y-m-d')));
            
            $em->persist($onerequest);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl("steria_solidaclic_account_request"));
    }
    
    /**
     * @Route("/edit")
     * @Secure(roles="ROLE_USER")
     * @Template("SteriaSolidaClicBundle:Account:edit.html.twig")
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $translator = $this->get('translator');
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $newmail = $request->request->get('inpEmail');
            
            $emailConstraint = new EmailConstraint();
            $emailConstraint->message = 'Your customized error message';
            $emailErrors = $this->get('validator')->validateValue($newmail, $emailConstraint);
            
            if ($user->getEmail() !== $newmail && count($emailErrors) == 0) {
                $user->setEmail($newmail);
                
                //all is good!
                $this->get('session')->getFlashBag()->add('success', $translator->trans('Adresse e-mail modifiée.'));
            }
            else if (count($emailErrors) > 0) {
                //bad mail
                $this->get('session')->getFlashBag()->add('danger', $translator->trans('Adresse e-mail invalide.'));
            }
            
            $passwdnw1 = $request->request->get('inpPasswdNew1');
            $passwdnw2 = $request->request->get('inpPasswdNew2');
            $passwdold = $request->request->get('inpPasswdOld');
            
            if (!empty($passwdnw1) || !empty($passwdnw1) || !empty($passwdnw1)) {
            
                $encodedPass = $encoder->encodePassword($passwdold, $user->getSalt());
                if ($user->getPassword() === $encodedPass) {
                
                    if (!empty($passwdnw1) && $passwdnw1 === $passwdnw2) {
                        $user->setPlainPassword($passwdnw1);
                        
                        $userManager = $this->container->get('fos_user.user_manager');
                        $userManager->updatePassword($user);
                        
                        //all is good!
                        $this->get('session')->getFlashBag()->add('success', $translator->trans('Votre mot de passe a été changé.'));
                    }
                    else {
                        //new password didn't match
                        $this->get('session')->getFlashBag()->add('danger', $translator->trans('Les mot de passe ne correspondent pas.'));
                    }
                }
                else {
                    //bad old password
                    $this->get('session')->getFlashBag()->add('danger', $translator->trans('Mauvais mot de passe.'));
                }
            }
            
            $em->persist($user);
            $em->flush();
        }
        
        return array(
            "user"    =>    $user,
        );
    }
    
    /**
     * @Route("/address", defaults={"addrid" = null})
     * @Route("/address/{addrid}/edit", name="steria_solidaclic_account_addressedit", requirements={"addrid" = "\d+"})
     * @Secure(roles="ROLE_USER")
     * @Template("SteriaSolidaClicBundle:Account:address.html.twig")
     */
    public function addressAction($addrid)
    {
        // récuperation des elements nécéssaires
        $em = $this->getDoctrine()->getManager();
        $repaddr = $em->getRepository('SteriaSolidaClicBundle:Address');
        $translator = $this->get('translator');
        $user = $this->get('security.context')->getToken()->getUser();
        
        /* début formulaire et traitement */
        $address = new Address;
        if ($addrid !== null) {
            $foundaddr = $repaddr->findOneBy(
                            array(
                                'id' => $addrid, 
                                'fkUser' => $user,
                            )
            );
            
            // est-ce qu'on a un résultat
            if ($foundaddr === null) {
                return $this->redirect($this->generateUrl("steria_solidaclic_account_address"));
            }
            else {
                $address = $foundaddr;
            }
        }
        
        $form = $this->createForm(new AddressType, $address);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            $address->setFkUser($user);
            
            $googlecoord = $this->container->get('steria_solida_clic.googlemap');
            $coords = $googlecoord->addressToCoord($address->getAddress(), $address->getCity(), $address->getZip());
            
            if ($form->isValid() && $coords !== null) {
                $address->setLat($coords['latitude']);
                $address->setLon($coords['longitude']);
                
                $em->persist($address);
                $em->flush();
                
                // formulaire ok, on boucle pour vider le formulaire
                return $this->redirect($this->generateUrl("steria_solidaclic_account_address"));
            }
            else {
                $this->get('session')->getFlashBag()->add('danger', $translator->trans('Adresse invalide.'));
            }
        }
        /* fin formulaire et traitement */
        
        // récupération de toutes les adresses de l'utilisateur
        $alladdress = $repaddr->findByFkUser($user);
        
        // enoit des informations à la vue
        return array(
                'form'       => $form->createView(),
                'alladdress' => $alladdress,
        );
    }
    
    /**
     * @Route("/address/{addrid}/delete", requirements={"addrid" = "\d+"})
     * @Secure(roles="ROLE_USER")
     */
    public function addressDeleteAction($addrid)
    {
        // récuperation des elements nécéssaires
        $em = $this->getDoctrine()->getManager();
        $repaddr = $em->getRepository('SteriaSolidaClicBundle:Address');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $foundaddr = $repaddr->findOneBy(
                        array(
                            'id' => $addrid, 
                            'fkUser' => $user,
                        )
        );
        
        // est-ce qu'on a un résultat
        if ($foundaddr !== null) {
            $em->remove($foundaddr);
            $em->flush();
        }
        
        // retour sur la liste des adresses
        return $this->redirect($this->generateUrl("steria_solidaclic_account_address"));
    }
}
