<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Board;
use AppBundle\Entity\Player;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BoardController extends Controller {

    /**
     * @Route("/do", name="doBoard")
     */
    public function doAction() {
        $oBoard = new Board;
        $oPlayer = new Player;
        $aBoard = $oBoard->getGrid();
        $aBoard[1][1]->setPlayer($oPlayer);
        return $this->render('AppBundle:Board:do.html.twig', array('board' => $aBoard
        ));
    }

}
