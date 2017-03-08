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
// Génération de la grille 15X12
        $aBoard = [];
        $iCases = 0;
        for ($y = 0; $y <= 12; $y++) {
            $aBoard = array("y" => $y);
            $iCases++;

            for ($x = 0; $x <= 17; $x++) {
                $aBoard = array("x" => $x);
                $iCases++;
            }
        }
        $this->grid = $aBoard;

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
    public function setWalls($walls)
    {
        $this->walls = $walls;

        return $this;
    }

    /**
     * Get walls
     *
     * @return array
     */
    public function getWalls()
    {
        return $this->walls;
    }
}
