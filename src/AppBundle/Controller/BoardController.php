<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BoardController extends Controller {

    /**
     * @Route("/do", name="doBoard")
     */
    public function doAction() {
        return $this->render('AppBundle:Board:do.html.twig', array(
                        // ...
        ));
    }

}
