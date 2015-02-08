<?php
/*
 * DO NOT USE THIS !!!
 */
namespace Steria\SolidaClicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/login")
     */
    public function loginAction()
    {
        return new Response('Not yet!');
    }
}
