<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

    /**
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
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

            $oUserForm->setPassword($this->cryptPwd($oUserForm->getPassword()));


            if ($oUser && $oUser->getPassword() == $oUserForm->getPassword()) {
                $request->getSession()->set('isConnected', 'true');
                $sLog = $oUser->getLogin();
                $iIdLog = $oUser->getId();
                $request->getSession()->set('login', $sLog);
                $request->getSession()->set('id_user', $iIdLog);
            }
            return $this->redirectToRoute('index');
        }
        return array('form' => $oForm->createView());
    }

    /**
     * @Route("/modifUser", name="modifUser")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function modifUserAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:User');
        $oUser = $repo->findOneByLogin($request->getSession()->get('login'));
        $oUser->setPassword('');
        $oForm = $this->createFormBuilder($oUser)
                ->add('login', TextType::class)
                ->add('password', TextType::class)
                ->add('save', SubmitType::class, array('label' => 'modifier'))
                ->getForm();
        $oForm->handleRequest($request);
        if ($oForm->isSubmitted()) {
            $oUser->setPassword($this->cryptPwd($oUser->getPassword()));
            $em->flush();
            $sLog = $oUser->getLogin();
            $request->getSession()->set('login', $sLog);
            return $this->redirectToRoute('index');
        }
        return array('form' => $oForm->createView());
    }

    /**
     * @Route("/createUser", name="createUser")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function createUserAction(Request $request) {
        $oUserForm = new User;
        $oForm = $this->createFormBuilder($oUserForm)->add('login', TextType::class)->add('password', PasswordType::class)->add('save', SubmitType::class, array('label' => 'Soumettre'))->getForm();
        $oForm->handleRequest($request);
        if ($oForm->isSubmitted() && $oForm->isValid()) {
            $repo = $this->getDoctrine()->getRepository('AppBundle:User');
            $oUser = $repo->findOneByLogin($oUserForm->getLogin());
            if (!$oUser) {
                $oUserForm->setPassword($this->cryptPwd($oUserForm->getPassword()));
                $em = $this->getDoctrine()->getManager();
                $em->persist($oUserForm);
                $em->flush();
                $request->getSession()->set('isConnected', 'true');
                $request->getSession()->set('login', $oUserForm->getLogin());
                $request->getSession()->set('id_user', $oUserForm->getId());
                return $this->redirectToRoute('index');
            }
        }
        return array('form' => $oForm->createView());
    }

    /**
     * @Route("/logout", name="logout")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function logoutAction(Request $request) {
        $request->getSession()->invalidate();
        return $this->redirectToRoute('index');
    }

    private function cryptPwd($sPwd) {
        return sha1('@Wi9H/z78y2]MKd/c(6V' . $sPwd);
    }

}
