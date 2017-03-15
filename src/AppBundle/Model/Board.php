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

    public function __construct() {
        $this->setGrid();
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
     * @param array $aUsers
     *
     * @return Board
     */
    public function setPlayers($aUsers) {
        $aPos = [
            ['x' => 1, 'y' => 1],
            ['x' => 15, 'y' => 1],
            ['x' => 1, 'y' => 11],
            ['x' => 15, 'y' => 11],
        ];

        $aBoard = $this->getGrid();
        foreach ($aUsers as $idx => $oUser) {
            $pl_x = $aPos[$idx]['x'];
            $pl_y = $aPos[$idx]['y'];

            $oPlayer = new Player;
            $oPlayer->setX($pl_x);
            $oPlayer->setY($pl_y);
            $oPlayer->setIdUser($oUser->getId());

            $aBoard[$pl_y][$pl_x]->setPlayer($oPlayer);

            $this->players[] = $oPlayer;
        }

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
        for ($y = 0; $y <= 12; $y++) {
            $aBoard[$y] = [];
            for ($x = 0; $x <= 16; $x++) {
                $aBoard[$y][$x] = new BCase();
                $aBoard[$y][$x]->setX($x);
                $aBoard[$y][$x]->setY($y);
            }
        }
        $this->grid = $this->generateWall($aBoard);
        $this->grid = $this->generateDestruWall($aBoard);

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
    public function setWalls($walls) {

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

    public function getIdGame() {
        return $this->idGame;
    }

    public function setIdGame($idGame) {
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

    public function generateDestruWall($aBoard) {
        for ($y = 0; $y <= 12; $y++) {
            for ($x = 0; $x <= 16; $x++) {
                if ($y > 4 && $y < 8 || $x > 4 && $x < 12) {
                    if (!$aBoard[$y][$x]->getItem()) {
                        $oItem = new Item();
                        $oItem->setNom('destruwall');
                        $aBoard[$y][$x]->setItem($oItem);
                    }
                }
            }
        }
        return $aBoard;
    }

    public function bomb(Player $player, $aBoard) {
        $oItem = new Item();
        $oItem->setNom('bomb');
        $Y = $player->getY();
        $X = $player->getX();
        switch ($player->getPrevMouv()) {
            case 'up' :
                if (!$aBoard[$Y - 1][$X]->getItem()) {
                    $aBoard[$Y - 1][$X]->setItem($oItem);
                }
                break;
            case 'down' :
                if (!$aBoard[$Y + 1][$X]->getItem()) {
                    $aBoard[$Y + 1][$X]->setItem($oItem);
                }
                break;
            case 'right' :
                if (!$aBoard[$Y][$X + 1]->getItem($oItem)) {
                    $aBoard[$Y][$X + 1]->setItem($oItem);
                }
                break;
            case 'left' :
                if (!$aBoard[$Y][$X - 1]->getItem($oItem)) {
                    $aBoard[$Y][$X - 1]->setItem($oItem);
                }
                break;
        }
    }

    public function doAction($action, $id_user) {
        foreach ($this->players as $key => $value) {
            if ($id_user == $value->getIdUser()) {
                $player = $this->players[$key];
                $playerY = $player->getY();
                $playerX = $player->getX();
            }
        }
        $aBoard = $this->getGrid();
        switch ($action) {
            case 'up' :
                $player->setPrevMouv($action);
                if (!$aBoard[$playerY - 1][$playerX]->getItem()) {
                    $this->grid[$playerY][$playerX]->setPlayer(NULL);
                    $playerY = $playerY - 1;
                    $player->setY($playerY);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'down' :
                $player->setPrevMouv($action);
                if (!$aBoard[$playerY + 1][$playerX]->getItem()) {
                    $this->grid[$playerY][$playerX]->setPlayer(NULL);
                    $playerY = $playerY + 1;
                    $player->setY($playerY);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'right' :
                $player->setPrevMouv($action);
                if (!$aBoard[$playerY][$playerX + 1]->getItem()) {
                    $this->grid[$playerY][$playerX]->setPlayer(NULL);
                    $playerX = $playerX + 1;
                    $player->setX($playerX);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'left' :
                $player->setPrevMouv($action);
                if (!$aBoard[$playerY][$playerX - 1]->getItem()) {
                    $this->grid[$playerY][$playerX]->setPlayer(NULL);
                    $playerX = $playerX - 1;
                    $player->setX($playerX);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'bomb':
                $this->bomb($player, $aBoard);
                break;
        }
    }

}
