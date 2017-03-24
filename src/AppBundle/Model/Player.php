<?php

namespace AppBundle\Model;

/**
 * Player
 *
 */
class Player {

    /**
     * @var int
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $pseudo;

    /**
     * @var int
     *
     */
    private $score;

    /**
     * @var int
     *
     */
    private $hp;

    /**
     * @var int
     *
     */
    private $y;

    /**
     * @var int
     *
     */
    private $x;

    /**
     * @var int
     *
     */
    private $initY;

    /**
     * @var int
     *
     */
    private $initX;

    /**
     * @var int
     *
     */
    private $idUser;

    public function __construct() {
        $this->score = 0;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Player
     */
    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo() {
        return $this->pseudo;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Player
     */
    public function setScore($score) {
        $this->score += $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore() {
        return $this->score;
    }

    /**
     * Set hp
     *
     * @param integer $hp
     *
     * @return Player
     */
    public function setHp($hp) {
        $this->hp = $hp;

        return $this;
    }

    /**
     * Get hp
     *
     * @return int
     */
    public function getHp() {
        return $this->hp;
    }

    /**
     * Set y
     *
     * @param integer $y
     *
     * @return Player
     */
    public function setY($y) {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return integer
     */
    public function getY() {
        return $this->y;
    }

    /**
     * Set x
     *
     * @param integer $x
     *
     * @return Player
     */
    public function setX($x) {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return integer
     */
    public function getX() {
        return $this->x;
    }

    public function getInitY() {
        return $this->initY;
    }

    public function getInitX() {
        return $this->initX;
    }

    public function setInitY($initY) {
        $this->initY = $initY;
    }

    public function setInitX($initX) {
        $this->initX = $initX;
    }

    public function getIdUser() {
        return $this->idUser;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

}
