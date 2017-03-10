<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BCase
 *
 * @ORM\Table(name="b_case")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BCaseRepository")
 */
class BCase {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="x", type="integer", nullable=true)
     */
    private $x;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="y", type="integer", nullable=true)
     */
    private $y;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="item", type="object", nullable=true)
     */
    private $item;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="player", type="object", nullable=true)
     */
    private $player;

    /**
     * Get id
     *
     * @return int
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
    function setId($id) {
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
    function getX() {
        return $this->x;
    }

    /**
     * Get y
     *
     * @return \stdClass
     */
    function getY() {
        return $this->y;
    }

    /**
     * Set player
     *
     * @param \stdClass $x
     *
     * @return BCase
     */
    function setX($x) {
        $this->x = $x;
    }

    /**
     * Set player
     *
     * @param \stdClass $y
     *
     * @return BCase
     */
    function setY($y) {
        $this->y = $y;
    }

}
