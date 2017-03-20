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
     * @var int
     *
     */
    private $x;

    /**
     * @var int
     *
     */
    private $y;

    function getX() {
        return $this->x;
    }

    function getY() {
        return $this->y;
    }

    function setX($x) {
        $this->x = $x;
    }

    function setY($y) {
        $this->y = $y;
    }

}
