<?php

namespace AppBundle\Model;

/**
 * BCase
 *
 */
class BCase {

    /**
     * @var int
     *
     */
    private $id;

    /**
     * @var \stdClass
     *
     */
    private $x;

    /**
     * @var \stdClass
     *
     */
    private $y;

    /**
     * @var \stdClass
     *
     */
    private $item;

    /**
     * @var \stdClass
     *
     */
    private $player;

    /**
     * Get id
     *
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param \stdClass $id
     *
     * @return BCase
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set item
     *
     * @param \stdClass $item
     *
     * @return BCase
     */
    public function setItem($item) {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \stdClass
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * Set player
     *
     * @param \stdClass $player
     *
     * @return BCase
     */
    public function setPlayer($player) {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \stdClass
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     * Get x
     *
     * @return \stdClass
     */
    public function getX() {
        return $this->x;
    }

    /**
     * Get y
     *
     * @return \stdClass
     */
    public function getY() {
        return $this->y;
    }

    /**
     * Set player
     *
     * @param \stdClass $x
     *
     * @return BCase
     */
    public function setX($x) {
        $this->x = $x;
    }

    /**
     * Set player
     *
     * @param \stdClass $y
     *
     * @return BCase
     */
    public function setY($y) {
        $this->y = $y;
    }

}
