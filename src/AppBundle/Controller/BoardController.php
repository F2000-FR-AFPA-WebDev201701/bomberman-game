<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BoardController extends Controller
{
    /**
     * @Route("/do")
     */
    public function doAction()
    {
        return $this->render('AppBundle:Board:do.html.twig', array(
            // ...
        ));
    }

}
