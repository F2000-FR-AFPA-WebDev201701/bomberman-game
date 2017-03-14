<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use AppBundle\Model\Board;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller {

    /**
     * @Route("/begin/{id}", name="begin")
     */
    public function beginAction($id) {
        $iGameId = $id;
        return $this->render('AppBundle:Game:begin.html.twig', array('id' => $iGameId
                        // ...
        ));
    }

    /**
     * @Route("/join/{id_game}/{id_user}"), name="join")
     */
    public function joinAction($id_game, $id_user) {
        //recup game en BDD
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Game');
        $oGame = $repo->findOneById($id_game);

        $aUsers[] = $id_user;
        $oGame->setUsers($aUsers);
        $em->flush();
    }

    /**
     * @Route("/lobby", name="lobby")
     * @Template
     */
    public function lobbyAction(Request $request) {
        $oGame = new Game;
        $oForm = $this->createForm(GameType::class, $oGame);
        $oForm->handleRequest($request);


        if ($oForm->isSubmitted() && $oForm->isValid()) {
            // renvoie sur la fonction createGame($oGame)
            $repo = $this->getDoctrine()->getRepository('AppBundle:User');
            $sUserLogin = $request->getSession()->get('login');
            $oUser = $repo->findOneByLogin($sUserLogin);

            $this->createGame($oGame, $oUser);

            return $this->redirectToRoute('join', array('id' => $oGame->getId()));
        }

        $repo = $this->getDoctrine()->getRepository('AppBundle:Game');
        $oAllGame = $repo->findAll();

        return array(
            'form' => $oForm->createView(),
            'allGame' => $oAllGame
        );
    }

    public function createGame($oGame, $oUser) {
        $oGame->setStatus(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($oGame);
        $em->flush();

        $this->createBoard($oGame);
        $em->flush();
    }

    public function joinGame($oGame, $oUser) {
        $temp = null;
        if ($oGame->getUsers()) {
            $temp = $oGame->getUsers() . ',';
        }

        $oGame->setUsers($temp . $oUser->getId());
        $this->isReady($oGame);
    }

    public function isReady($oGame) {
        $users = $oGame->getUsers();
        $aUsers = explode(',', $users);

        if ($oGame->getNbPlayers() == count($aUsers)) {
            $oGame->setStatus(1);
            $this->createBoard($oGame);
            return $this->redirectToRoute('refresh', array('id' => $oGame->getId()));
        }
    }

    /**
     * @Route("/play/{action}/{id_game}", name="play")
     */
    public function playAction($action, $id_game) {
        //recup game en BDD
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Game');
        $oGame = $repo->findOneById($id_game);

        //unserialize $oGame->data
        $oBoard = unserialize($oGame->getData());
        //test doAction
        $oBoard->doAction($action);
        //renvoie en BDD
        $seriaBoard = serialize($oBoard);
        $oGame->setData($seriaBoard);
        $em->flush();

        //$rend = $this->refreshAction($id_game);
        $this->refreshAction($id_game);
        //return $rend;
    }

    /**
     * @Route("/refresh/{id}", name="refresh")
     */
    public function refreshAction($id) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Game');
        $oGame = $repo->findOneById($id);

        //unserialize $oGame->data
        $oBoard = unserialize($oGame->getData());
        $aBoard = $oBoard->getGrid();
        $idBoard = $oBoard->getIdGame();

        return $this->render('AppBundle:Game:refresh.html.twig', array('board' => $aBoard, 'id' => $idBoard));
    }

    public function createBoard($oGame) {

        $oBoard = new Board;
        $oBoard->setPlayers($oGame->getUsers());
        $oBoard->setIdGame($oGame->getId());
        $seriaBoard = serialize($oBoard);
        $oGame->setData($seriaBoard);
    }

    /**
     *
     * @param type $id
     * @return type
     *
     * @Route("/waiting/{id}", name="waiting")
     */
    public function waitingGame($id) {
        return $this->render('AppBundle:Game:waiting.html.twig', array('id' => $id));
    }

}
