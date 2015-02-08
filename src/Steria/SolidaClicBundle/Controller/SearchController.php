<?php

namespace Steria\SolidaClicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * @Route("/", defaults={"rub" = null, "zip" = null, "page" = 1, "dist" = null})
     * @Route("/page-{page}", name="steria_solidaclic_search_indexpart", requirements={"page" = "\d+"}, defaults={"rub" = null, "zip" = null, "dist" = null})
     * @Route("/zip-{zip}-rub-{rub}-dst-{dist}-page-{page}", name="steria_solidaclic_search_indexfull", requirements={"rub" = "\d+", "page" = "\d+", "zip" = "\d+", "dist" = "\d+"})
     * @Template("SteriaSolidaClicBundle:Search:index.html.twig")
     */
    public function indexAction($rub, $page, $dist, $zip)
    {
        if ($rub == "0") $rub = null;
        if ($dist == "0") $dist = null;
        
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $session = $this->get('session');
        $translator = $this->get('translator');
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $inpCateg = $request->request->get('inpCateg');
            $inpDist = $request->request->get('inpDist');
            $inpZip = $request->request->get('inpZip');
            
            return $this->redirect(
                $this->generateUrl(
                    "steria_solidaclic_search_indexfull",
                    array(
                        'rub' => $inpCateg,
                        'page' => 1,
                        'dist' => $inpDist,
                        'zip' => $inpZip,
                    )
                )
            );
        }
        
        $lat = $lon = null;
        $err = "";
        
        if ($zip !== null && preg_match("#[0-9]{5}#", $zip)) {
            $googlecoord = $this->container->get('steria_solida_clic.googlemap');
            $coords = $googlecoord->addressZipToCoord($zip);
            
            if ($coords !== null) {
                $lat = $coords['latitude'];
                $lon = $coords['longitude'];
            }
            else {
                $err = $translator->trans('Code postal invalide invalide. Affichage de tous les résultats.');
            }
        }
        else {
            $err = $translator->trans('Code postal invalide invalide. Affichage de tous les résultats.');
        }
        
		$rephelp = $em->getRepository('SteriaSolidaClicBundle:HelpRequest');
		$max_result = 10;
		
		$help_cnt = $rephelp->countCateg($rub, $dist, $lat, $lon);
		$demandes = $rephelp->getList($rub, $dist, $lat, $lon, $page, $max_result);

		$allcatg = $em->getRepository('SteriaSolidaClicBundle:Category')->findAll();
		
		return array(
			'demandes' => $demandes,
			'page' => $page,
			'pages_count' => ceil($help_cnt / $max_result),
			'help_cnt' => $help_cnt,
            "rephelp" => null,
            "frmzip" => $zip,
            "frmdst" => $dist,
            "frmcat" => $rub,
            "frmerr" => $err,
            "catvalues" => $allcatg,
		);
    }

    /**
     * @Route("/view/{id}", requirements={"id" = "\d+"})
     * @Template("SteriaSolidaClicBundle:Search:view.html.twig")
     */
    public function viewAction($id)
    {
        // récuperation des elements nécéssaires
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $allrequest = $em->getRepository('SteriaSolidaClicBundle:HelpRequest')->findOneById($id);        
        
        return array( 
            "helprequest" => $allrequest,
        );
    }
}
