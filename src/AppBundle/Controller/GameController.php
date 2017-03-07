<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GameController extends Controller {

    /**
     * @Route("/begin")
     */
    public function beginAction() {
        return $this->render('AppBundle:Game:begin.html.twig', array(
                        // ...
        ));
    }

    /**
     * @Route("/close")
     */
    public function closeAction() {
        return $this->render('AppBundle:Game:close.html.twig', array(
                        // ...
        ));
    }

    /**
     * @Route("/join")
     */
    public function joinAction() {
        return $this->render('AppBundle:Game:join.html.twig', array(
                        // ...
        ));
    }

}
