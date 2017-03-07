<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PlayerController extends Controller
{
    /**
     * @Route("/move")
     */
    public function moveAction()
    {
        return $this->render('AppBundle:Player:move.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/bomb")
     */
    public function bombAction()
    {
        return $this->render('AppBundle:Player:bomb.html.twig', array(
            // ...
        ));
    }

}
