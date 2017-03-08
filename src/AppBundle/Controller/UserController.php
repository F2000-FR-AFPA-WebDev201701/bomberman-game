<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/modifUser", name="modifUser")
     * @Template
     */
    public function modifUserAction(Request $request) {
        $oUserForm = new User;
        $oForm = $this->createFormBuilder($oUserForm)
                ->add('login', TextType::class)
                ->add('password', TextType::class)
                ->add('save', SubmitType::class, array('label' => 'modifier'))
                ->getForm();
        $oForm->handleRequest($request);

        return array('form' => $oForm->createView());
    }

}
