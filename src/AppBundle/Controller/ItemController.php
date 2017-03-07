<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ItemController extends Controller
{
    /**
     * @Route("/bloc")
     */
    public function blocAction()
    {
        return $this->render('AppBundle:Item:bloc.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/coordPlayer")
     */
    public function coordPlayerAction()
    {
        return $this->render('AppBundle:Item:coord_player.html.twig', array(
            // ...
        ));
    }

}
