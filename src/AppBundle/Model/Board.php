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

    /**
     * @var array
     *
     */
    private $aBombs;

    /**
     * @var array
     *
     */
    private $aExplosions;

    /**
     * @var integer
     *
     */
    private $idGame;

    public function __construct() {
        $this->players = [];
        $this->aBombs = [];
        $this->aExplosions = [];

        $this->setGrid();
    }

    function getAExplosions() {
        return $this->aExplosions;
    }

    public function getABombs() {
        return $this->aBombs;
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
            $oPlayer->setInitX($pl_x);
            $oPlayer->setInitY($pl_y);
            $oPlayer->setIdUser($oUser->getId());
            $oPlayer->setPseudo($oUser->getLogin());

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
        $this->grid = [];
        for ($y = 0; $y <= 12; $y++) {
            $this->grid[$y] = [];
            for ($x = 0; $x <= 16; $x++) {
                $this->grid[$y][$x] = new BCase();
                $this->grid[$y][$x]->setX($x);
                $this->grid[$y][$x]->setY($y);
            }
        }

        $this->generateWall();
        $this->generateDestruWall();

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

    public function getAAnim() {
        return $this->aAnim;
    }

    public function setAAnim($aAnim) {
        $this->aAnim = $aAnim;
    }

    public function getIdGame() {
        return $this->idGame;
    }

    public function setIdGame($idGame) {
        $this->idGame = $idGame;
    }

    public function generateWall() {
        for ($y = 0; $y <= 12; $y++) {
            for ($x = 0; $x <= 16; $x++) {
                if ($y == 0 || $y == 12 || $x == 0 || $x == 16) {
                    $oItem = new Item();
                    $oItem->setNom('wall');

                    $this->grid[$y][$x]->setItem($oItem);
                } elseif ($x % 2 == 0 && $y % 2 == 0) {
                    $oItem = new Item();
                    $oItem->setNom('wall');

                    $this->grid[$y][$x]->setItem($oItem);
                }
            }
        }
    }

    public function generateDestruWall() {
        for ($y = 0; $y <= 12; $y++) {
            for ($x = 0; $x <= 16; $x++) {
                if ($y > 4 && $y < 8 || $x > 4 && $x < 12) {
                    if (!$this->grid[$y][$x]->getItem()) {
                        $oItem = new Item();
                        $oItem->setNom('destruwall');

                        $this->grid[$y][$x]->setItem($oItem);
                    }
                }
            }
        }
    }

    public function setBomb(Player $player) {
        $oBomb = new Bomb($player->getId());

        $Y = $player->getY();
        $X = $player->getX();
        $oBomb->setX($X);
        $oBomb->setY($Y);

        $this->grid[$Y][$X]->setBomb($oBomb);

        $this->aBombs[] = $oBomb;
    }

    public function boom(Bomb $oBomb) {
        $X = $oBomb->getX();
        $Y = $oBomb->getY();
        $this->boomItem($oBomb);
        $this->boomPlayer($oBomb);
        $aExplosion = [
            'origin' => [
                'x' => $X,
                'y' => $Y,
            ]
        ];
        $this->aExplosions[] = $aExplosion;
        $this->grid[$Y][$X]->setBomb(NULL);
    }

    public function doAction($action, $id_user) {
        foreach ($this->players as $key => $value) {
            if ($id_user == $value->getIdUser()) {
                $player = $this->players[$key];
                $playerY = $player->getY();
                $playerX = $player->getX();
            }
        }

        switch ($action) {
            case 'up' :
                if (!$this->grid[$playerY - 1][$playerX]->getItem()) {
                    $this->grid[$playerY][$playerX]->setPlayer(NULL);
                    $playerY = $playerY - 1;
                    $player->setY($playerY);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'down' :
                if (!$this->grid[$playerY + 1][$playerX]->getItem()) {
                    $this->grid[$playerY][$playerX]->setPlayer(NULL);
                    $playerY = $playerY + 1;
                    $player->setY($playerY);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'right' :
                if (!$this->grid[$playerY][$playerX + 1]->getItem()) {
                    $this->grid[$playerY][$playerX]->setPlayer(NULL);
                    $playerX = $playerX + 1;
                    $player->setX($playerX);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'left' :
                if (!$this->grid[$playerY][$playerX - 1]->getItem()) {
                    $this->grid[$playerY][$playerX]->setPlayer(NULL);
                    $playerX = $playerX - 1;
                    $player->setX($playerX);
                    $this->grid[$playerY][$playerX]->setPlayer($player);
                }
                break;
            case 'bomb':
                $this->setBomb($player);
                break;
        }
    }

    public function doCycle() {
        $this->aExplosions = [];
        foreach ($this->aBombs as $key => $oBomb) {
            if ($oBomb->isExploded()) {
                $this->boom($oBomb);
                unset($this->aBombs[$key]);
            }
        }
    }

    private function doScore(Bomb $oBomb, Player $oPlayer) {
        ($oBomb->getIdPlayer() == $oPlayer->getId()) ? $oPlayer->setScore(-1) : $oPlayer->setScore(1);
    }

    private function boomItem(Bomb $oBomb) {
        $X = $oBomb->getX();
        $Y = $oBomb->getY();
        $itemLeft = $this->grid[$Y][$X - $oBomb::STRENGTH]->getItem();
        $itemRight = $this->grid[$Y][$X + $oBomb::STRENGTH]->getItem();
        $itemUp = $this->grid[$Y - $oBomb::STRENGTH][$X]->getItem();
        $itemDown = $this->grid[$Y + $oBomb::STRENGTH][$X]->getItem();
        if ($itemDown && $itemDown->getNom() != "wall") {
            $this->grid[$Y + $oBomb::STRENGTH][$X]->setItem(NULL);
            $this->grid[$Y + $oBomb::STRENGTH][$X]->setPlayer(NULL);
        }
        if ($itemLeft && $itemLeft->getNom() != "wall") {
            $this->grid[$Y][$X - $oBomb::STRENGTH]->setItem(NULL);
            $this->grid[$Y][$X - $oBomb::STRENGTH]->setPlayer(NULL);
        }
        if ($itemRight && $itemRight->getNom() != "wall") {
            $this->grid[$Y][$X + $oBomb::STRENGTH]->setItem(NULL);
            $this->grid[$Y][$X + $oBomb::STRENGTH]->setPlayer(NULL);
        }
        if ($itemUp && $itemUp->getNom() != "wall") {
            $this->grid[$Y - $oBomb::STRENGTH][$X]->setItem(NULL);
            $this->grid[$Y - $oBomb::STRENGTH][$X]->setPlayer(NULL);
        }
    }

    private function boomPlayer(Bomb $oBomb) {
        $X = $oBomb->getX();
        $Y = $oBomb->getY();
        $playerLeft = $this->grid[$Y][$X - $oBomb::STRENGTH]->getPlayer();
        $playerRight = $this->grid[$Y][$X + $oBomb::STRENGTH]->getPlayer();
        $playerUp = $this->grid[$Y - $oBomb::STRENGTH][$X]->getPlayer();
        $playerDown = $this->grid[$Y + $oBomb::STRENGTH][$X]->getPlayer();
        if ($playerDown) {
            $this->grid[$Y + $oBomb::STRENGTH][$X]->setPlayer(NULL);
            $this->hitPlayer($playerDown);
            $this->doScore($oBomb, $playerDown);
        }
        if ($playerLeft) {
            $this->grid[$Y][$X - $oBomb::STRENGTH]->setPlayer(NULL);
            $this->hitPlayer($playerLeft);
            $this->doScore($oBomb, $playerLeft);
        }
        if ($playerRight) {
            $this->grid[$Y][$X + $oBomb::STRENGTH]->setPlayer(NULL);
            $this->hitPlayer($playerRight);
            $this->doScore($oBomb, $playerRight);
        }
        if ($playerUp) {
            $this->grid[$Y - $oBomb::STRENGTH][$X]->setPlayer(NULL);
            $this->hitPlayer($playerUp);
            $this->doScore($oBomb, $playerUp);
        }
    }

    private function hitPlayer(Player $player) {
        $player->setY($player->getInitY());
        $player->setX($player->getInitX());
        $this->grid[$player->getInitY()][$player->getInitX()]->setPlayer($player);
    }

}
