<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pluto
 *
 * @ORM\Table(name="Pluto")
 * @ORM\Entity
 */
class Pluto
{
    /**
     * @var string
     *
     * @ORM\Column(name="longt", type="decimal", precision=10, scale=7, nullable=false)
     */
    private $longt;

    /**
     * @var string
     *
     * @ORM\Column(name="distAU", type="decimal", precision=11, scale=9, nullable=false)
     */
    private $distau;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set longt
     *
     * @param string $longt
     *
     * @return Pluto
     */
    public function setLongt($longt)
    {
        $this->longt = $longt;

        return $this;
    }

    /**
     * Get longt
     *
     * @return string
     */
    public function getLongt()
    {
        return $this->longt;
    }

    /**
     * Set distau
     *
     * @param string $distau
     *
     * @return Pluto
     */
    public function setDistau($distau)
    {
        $this->distau = $distau;

        return $this;
    }

    /**
     * Get distau
     *
     * @return string
     */
    public function getDistau()
    {
        return $this->distau;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
