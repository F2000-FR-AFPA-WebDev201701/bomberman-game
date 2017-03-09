<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Board;

class BoardController extends Controller {

    /**
     * @Route("/do", name="doBoard")
     */
    public function doAction() {
        $oBoard = new Board;
        $aBoard = $oBoard->getGrid();
        return $this->render('AppBundle:Board:do.html.twig', array('board' => $aBoard
        ));
    }

}
