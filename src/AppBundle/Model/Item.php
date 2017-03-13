<?php

namespace AppBundle\Model;

/**
 * Item
 *
 */
class Item {

    /**
     * @var int
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $nom;

    /**
     * @var int
     *
     */
    private $coordX;

    /**
     * @var int
     *
     */
    private $coordY;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Item
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set coord
     *
     * @param integer $coordX
     *
     * @return Item
     */
    public function setCoordX($coordX) {
        $this->coord = $coordX;

        return $this;
    }

    /**
     * Get coordX
     *
     * @return int
     */
    public function getCoordX() {
        return $this->coordX;
    }

    /**
     * Set coordY
     *
     * @param integer $coordY
     *
     * @return Item
     */
    public function setCoordY($coordY) {
        $this->coordY = $coordY;

        return $this;
    }

    /**
     * Get coordY
     *
     * @return int
     */
    public function getCoordY() {
        return $this->coordY;
    }

}
