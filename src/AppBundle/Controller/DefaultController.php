<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    /**
     * @Route("/", name="index")
     */
    public function indexAction() {
        return $this->render("AppBundle::index.html.twig");
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentionsAction() {
        return $this->render("AppBundle::mentions.html.twig");
    }

}
