<?php

namespace AppBundle\Entity;

use AppBundle\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="GameRepository")
 */
class Game {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     *
     * @var integer
     *
     * @ORM\Column(name="nbPlayers", type="integer", length=1)
     */
    private $nbPlayers;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=255, nullable=true)
     */
    private $data;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Game
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Game
     */
    public function setData($data) {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Set nbPlayers
     *
     * @param integer $nbPlayers
     *
     * @return Game
     */
    public function setNbPlayers($nbPlayers) {
        $this->nbPlayers = $nbPlayers;

        return $this;
    }

    /**
     * Get nbPlayers
     *
     * @return integer
     */
    public function getNbPlayers() {
        return $this->nbPlayers;
    }

}
