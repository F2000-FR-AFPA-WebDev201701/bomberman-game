<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Board;

class BoardController extends Controller {

    /**
     * @Route("/do")
     */
    public function generateBoardAction() {




        // Génération des murs
        $aGrid = $oBoard->getGrid();
        foreach ($aGrid["y"] as $y) {
            if ($y == 0 && $y == 12 && $y != 1 && $y != 11) {
                foreach ($aGrid["x"] as $x) {
                    if ($x == 0 && $x == 17 && $x != 1 && $x != 16) {

                    }
                }
            }
        }
        $oBoard->setCases($iCases);
    }

}
