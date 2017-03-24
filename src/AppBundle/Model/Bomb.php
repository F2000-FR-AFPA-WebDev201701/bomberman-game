<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Model;

/**
 * Bomb
 *
 */
class Bomb {

    const STRENGTH = 1;

    /**
     * @var string
     *
     */
    private $timestamp;

    /**
     * @var int
     *
     */
    private $x;

    /**
     * @var int
     *
     */
    private $y;
    private $idPlayer;

    public function __construct($idPlayer) {
        $this->idPlayer = $idPlayer;
        $this->timestamp = date('U');
    }

    public function isExploded() {
        $sAdd = $this->timestamp + 4;
        if (date('U') >= $sAdd) {
            return true;
        }
        return false;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

    public function setX($x) {
        $this->x = $x;
    }

    public function setY($y) {
        $this->y = $y;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function getIdPlayer() {
        return $this->idPlayer;
    }

    public function setIdPlayer($idPlayer) {
        $this->idPlayer = $idPlayer;
    }

}
