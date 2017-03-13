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

            $em = $this->getDoctrine()->getManager();
            $em->persist($oGame);
            $em->flush();

            $this->createBoard($oGame);
            $em->flush();



            return $this->redirectToRoute('refresh', array('id' => $oGame->getId()));
        }

        $repo = $this->getDoctrine()->getRepository('AppBundle:Game');

        $oAllGame = $repo->findAll();

        return array('form' => $oForm->createView(),
            'allGame' => $oAllGame);
    }

    /**
     * @Route("/play/{action}/{id_game}", name="play")
     * @Template
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
    }

    /**
     * @Route("/refresh/{id}", name="refresh")
     * @Template
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

}
