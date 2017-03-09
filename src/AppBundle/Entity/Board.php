<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Board
 *
 * @ORM\Table(name="board")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BoardRepository")
 */
class Board {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="grid", type="array")
     */
    private $grid;

    /**
     * @var array
     *
     * @ORM\Column(name="wall", type="array")
     */
    private $walls;

    /**
     * @var array
     *
     * @ORM\Column(name="cases", type="array")
     */
    private $cases;

    /**
     * @var array
     *
     * @ORM\Column(name="players", type="array")
     */
    private $players;

    function __construct() {
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
     * @param array $players
     *
     * @return Board
     */
    public function setPlayers($players) {
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
        // Génération de la grille 17X12
        $aBoard = [];
        $i = 0;
        for ($y = 0; $y <= 12; $y++) {
            $aBoard[$y] = [];
            for ($x = 0; $x <= 16; $x++) {
                $aBoard[$y][$x] = new BCase();
                $aBoard[$y][$x]->setId($i++);
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

}
