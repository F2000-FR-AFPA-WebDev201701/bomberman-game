<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BCase
 *
 * @ORM\Table(name="b_case")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BCaseRepository")
 */
class BCase
{
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set item
     *
     * @param \stdClass $item
     *
     * @return BCase
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \stdClass
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set player
     *
     * @param \stdClass $player
     *
     * @return BCase
     */
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \stdClass
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
