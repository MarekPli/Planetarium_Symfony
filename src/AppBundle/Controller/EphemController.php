<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EphemController extends Controller
{
    /**
     * @Route("/", name="ephemerids")
     */
    public function indexAction(Request $request)
    {
        return $this->render('ephem/index.html.twig');
    }
}
