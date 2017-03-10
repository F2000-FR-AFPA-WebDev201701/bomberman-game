<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Board;
use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
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
            $oGame->setStatus(0);


            $repo = $this->getDoctrine()->getRepository('AppBundle:User');
            $sUserLogin = $request->getSession()->get('login');
            $oUser = $repo->findOneByLogin($sUserLogin);
            $oGame->setUsers($oUser->getId());

            $this->createBoard($oGame);

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

    /**
     * @Route("/play/{id}/{id_game}", name="play")
     * @Template
     */
    public function playAction($id, $action) {
        switch ($action) {

        }
    }

    /**
     * @Route("/refresh", name="refresh")
     * @Template
     */
    public function refreshAction() {

    }

    public function createBoard($oGame) {

        $oBoard = new Board;
        $oBoard->setPlayers($oGame->getUsers());
        $seriaBoard = serialize($oBoard);
        $oGame->setData($seriaBoard);
    }

}
