<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Form\Type\GameType;
use AppBundle\Model\Board;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller {

    /**
     * @Route("/begin/{id}", name="begin")
     * @Method({"GET", "POST"})
     */
    public function beginAction($id) {
        $iGameId = $id;
        return $this->render('AppBundle:Game:begin.html.twig', array('id' => $iGameId));
    }

    /**
     * @Route("/lobby", name="lobby")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function lobbyAction(Request $request) {

        $oGame = new Game;
        $oForm = $this->createForm(GameType::class, $oGame);
        $oForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();


        if ($oForm->isSubmitted() && $oForm->isValid()) {
            $oGame->setStatus(0);
            $em->persist($oGame);
            $em->flush();
            // renvoie sur la route createAction($oGame)
            return $this->redirectToRoute('create', array('id_game' => $oGame->getId()));
        }

        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game');
        $repoUser = $em->getRepository('AppBundle:User');
        $oAllGame = $repoGame->findAll();

        $this->deleteGames($em, $oAllGame, $repoUser);


        $oAllGame = $repoGame->findAll();

        return array(
            'form' => $oForm->createView(),
            'allGame' => $oAllGame,
        );
    }

    private function deleteGames($em, $oAllGame, $repoUser) {

        $oNewDate = new DateTime();

        if ($oAllGame) {

            foreach ($oAllGame as $Game) {

                $timeGame = $Game->getDate();
                $interval = $timeGame->diff($oNewDate);

                if ($interval->format('%a') >= 10) {


                    $oUser = $repoUser->findByGame($Game->getId());

                    foreach ($oUser as $user) {
                        $user->setGame();
                    }

                    $em->flush();
                    $em->remove($Game);
                    $em->flush();
                }
            }
        }
    }

    /**
     * @Route("/create/{id_game}", name="create")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function createAction($id_game) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Game');
        $oGame = $repo->findOneById($id_game);

        $oGame->setStatus(0);

        $oBoard = new Board();
        $sSerial = serialize($oBoard);
        $oGame->setData($sSerial);

        $em = $this->getDoctrine()->getManager();
        $em->persist($oGame);
        $em->flush();

        return $this->redirectToRoute('join', array('id_game' => $oGame->getId()));
    }

    /**
     * @Route("/join/{id_game}", name="join")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function joinAction($id_game, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $iIdUser = $request->getSession()->get('id_user');

        $repoGame = $this->getDoctrine()->getRepository('AppBundle:Game');
        $oGame = $repoGame->find($id_game);
        $repoUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $oUser = $repoUser->find($iIdUser);

        $oGame->addUser($oUser);
        $oUser->setGame($oGame);

        $oGame->addUser($oUser);
        $em->persist($oGame);
        $em->flush();

        if ($oGame->getNbPlayers() == count($oGame->getUsers())) {
            $oGame->setStatus(1);
            $oBoard = unserialize($oGame->getData());
            $oBoard->setPlayers($oGame->getUsers());
            $oGame->setData(serialize($oBoard));

            $em->flush();

            return $this->redirectToRoute('begin', array('id' => $oGame->getId(), 'status' => $oGame->getStatus()));
        }
        return $this->redirectToRoute('begin', array('id' => $oGame->getId(), 'status' => $oGame->getStatus()));
    }

    /**
     * @Route("/play/{action}/{id_game}/{id_user}", name="play")
     * @Method({"GET", "POST"})
     */
    public function playAction($action, $id_game, $id_user) {
        //recup game en BDD
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Game');
        $oGame = $repo->findOneById($id_game);

        //unserialize $oGame->data
        $oBoard = unserialize($oGame->getData());
        //test doAction
        $oBoard->doAction($action, $id_user);
        //renvoie en BDD
        $seriaBoard = serialize($oBoard);
        $oGame->setData($seriaBoard);
        $em->flush();

        $rend = $this->refreshAction($id_game);
        return $rend;
    }

    /**
     * @Route("/refresh/{id_game}", name="refresh")
     * @Method({"GET", "POST"})
     */
    public function refreshAction($id_game) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Game');
        $oGame = $repo->findOneById($id_game);

        $oBoard = unserialize($oGame->getData());
        $oBoard->doCycle();
        //renvoie en BDD
        $seriaBoard = serialize($oBoard);
        $oGame->setData($seriaBoard);
        $em->flush();

        return $this->render('AppBundle:Game:refresh.html.twig', array('board' => $oBoard, 'id' => $oGame->getId(), 'status' => $oGame->getStatus()));
    }

    /**
     * @Route("/hud/{id_game}", name="hud")
     * @Method({"GET", "POST"})
     */
    public function hudAction($id_game) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Game');
        $oGame = $repo->findOneById($id_game);

        $oBoard = unserialize($oGame->getData());

        return $this->render('AppBundle:Game:hud.html.twig', array('id' => $oGame->getId(), 'pseudo' => $oGame->getId(), 'status' => $oGame->getStatus(), 'players' => $oBoard->getPlayers()));
    }

    /**
     * @Route("/close/{id_game}", name="close")
     * @Method({"GET", "POST"})
     */
    public function closeAction($id_game) {

        $em = $this->getDoctrine()->getManager();
        $repoGame = $em->getRepository('AppBundle:Game');
        $oGame = $repoGame->findOneById($id_game);

        $oGame->setStatus(2);
        $em->flush();

        return $this->redirectToRoute('lobby');
    }

}
