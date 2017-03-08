<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;

class UserController extends Controller {

    /**
     * @Route("/login", name="login")
     * @Template
     */
    public function loginAction(Request $request) {
        $oUserForm = new User;
        $oForm = $this->createForm(UserType::class, $oUserForm);
        $oForm->handleRequest($request);
        $sLogin = $oUserForm->getLogin();

        if ($oForm->isSubmitted()) {
            $repo = $this->getDoctrine()->getRepository('AppBundle:User');
            $oUser = $repo->findOneByLogin($sLogin);
            if ($oUser && $oUser->getPassword() == $oUserForm->getPassword()) {
                $request->getSession()->set('isConnected', 'true');
                $sLog = $oUser->getLogin();
                $request->getSession()->set('login', $sLog);
            }
            return $this->redirectToRoute('index');
        }
        return array('form' => $oForm->createView());
    }

}
