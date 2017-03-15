<?php

use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Routing\Route;

namespace AppBundle\Controller;

class DefaultController extends Controller {

    /**
     * @Route("/index", name="index")
     */
    public function indexAction() {
        return $this->render("AppBundle::index.html.twig");
    }

}
