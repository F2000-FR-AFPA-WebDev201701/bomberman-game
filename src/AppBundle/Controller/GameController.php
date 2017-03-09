<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/lobby", name="lobby")
     * @Template
     */
    public function lobbyAction(Request $request) {
        $oGame = new Game;
        $oForm = $oForm = $this->createForm(GameType::class, $oGame);
        $oForm->handleRequest($request);


        if ($oForm->isSubmitted() && $oForm->isValid()) {
            $oGame->setName($oGame->getName());
            $oGame->setStatus(0);
            $oGame->setNbPlayers($oGame->getNbPlayers());

            $repo = $this->getDoctrine()->getRepository('AppBundle:User');
            $sUserLogin = $request->getSession()->get('login');
            $oUser = $repo->findOneBy(array('login' => $sUserLogin));
            $oGame->setUsers($oUser->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($oGame);
            $em->flush();


            return $this->redirectToRoute('doBoard', array('id' => $oGame->getId()));
        }

        $repo = $this->getDoctrine()->getRepository('AppBundle:Game');

        $oAllGame = $repo->findAll();

        return array('form' => $oForm->createView(),
            'allGame' => $oAllGame);
    }

}
