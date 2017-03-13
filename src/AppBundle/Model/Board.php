<?php

namespace AppBundle\Model;

/**
 * Board
 *
 */
class Board {

    /**
     * @var int
     *
     */
    private $id;

    /**
     * @var array
     *
     */
    private $grid;

    /**
     * @var array
     *
     */
    private $walls;

    /**
     * @var array
     *
     */
    private $cases;

    /**
     * @var array
     *
     */
    private $players;
    private $idGame;

    function __construct() {
        $this->setGrid();
        $this->setPlayers();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set cases
     *
     * @param array $cases
     *
     * @return Board
     */
    public function setCases($cases) {
        $this->cases = $cases;

        return $this;
    }

    /**
     * Get cases
     *
     * @return array
     */
    public function getCases() {
        return $this->cases;
    }

    /**
     * Set players
     *
     * @param array $players
     *
     * @return Board
     */
    public function setPlayers() {
        $aBoard = $this->getGrid();
        $oPlayer = new Player;
        $oPlayer->setX(1);
        $oPlayer->setY(1);
        $aBoard[1][1]->setPlayer($oPlayer);
        $players['1'] = $oPlayer;
        $this->players = $players;

        return $this;
    }

    /**
     * Get players
     *
     * @return array
     */
    public function getPlayers() {
        return $this->players;
    }

    /**
     * Set grid
     *
     * @param array $grid
     *
     * @return Board
     */
    public function setGrid() {
        // Génération de la grille 16X12
        $aBoard = [];
        $i = 0;
        for ($y = 0; $y <= 12; $y++) {
            $aBoard[$y] = [];
            for ($x = 0; $x <= 16; $x++) {
                $aBoard[$y][$x] = new BCase();
                $aBoard[$y][$x]->setX($x);
                $aBoard[$y][$x]->setY($y);
            }
        }
        $this->grid = $this->generateWall($aBoard);

        return $this;
    }

    /**
     * Get grid
     *
     * @return array
     */
    public function getGrid() {
        return $this->grid;
    }

    /**
     * Set walls
     *
     * @param array $walls
     *
     * @return Board
     */
    public function setWalls() {

        $this->walls = $walls;

        return $this;
    }

    /**
     * Get walls
     *
     * @return array
     */
    public function getWalls() {
        return $this->walls;
    }

    function getIdGame() {
        return $this->idGame;
    }

    function setIdGame($idGame) {
        $this->idGame = $idGame;
    }

    public function generateWall($aBoard) {
        for ($y = 0; $y <= 12; $y++) {
            for ($x = 0; $x <= 16; $x++) {
                if ($y == 0 || $y == 12 || $x == 0 || $x == 16) {
                    $oItem = new Item();
                    $oItem->setNom('wall');
                    $aBoard[$y][$x]->setItem($oItem);
                } elseif ($x % 2 == 0 && $y % 2 == 0) {
                    $oItem = new Item();
                    $oItem->setNom('wall');
                    $aBoard[$y][$x]->setItem($oItem);
                }
            }
        }
        return $aBoard;
    }

    public function doAction($action) {
        $player = $this->players['1'];
        $playerY = $player->getY();
        $playerX = $player->getX();
        $aBoard = $this->getGrid();
        $this->grid[$playerY][$playerX]->setPlayer(NULL);
        switch ($action) {
            case 'up' :
                if (!$aBoard[$playerY - 1][$playerX]->getItem()) {
                    $playerY = $playerY - 1;
                    $player->setY($playerY);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                } else {
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'down' :
                if (!$aBoard[$playerY + 1][$playerX]->getItem()) {
                    $playerY = $playerY + 1;
                    $player->setY($playerY);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                } else {
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'right' :
                if (!$aBoard[$playerY][$playerX + 1]->getItem()) {
                    $playerX = $playerX + 1;
                    $player->setX($playerX);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                } else {
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'left' :
                if (!$aBoard[$playerY][$playerX - 1]->getItem()) {
                    $playerX = $playerX - 1;
                    $player->setX($playerX);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                } else {
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
        }
    }

}
