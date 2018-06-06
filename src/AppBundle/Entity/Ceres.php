<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ceres
 *
 * @ORM\Table(name="ceres")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CeresRepository")
 */
class Ceres
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
     * @var string
     *
     * @ORM\Column(name="longt", type="decimal", precision=10, scale=7)
     */
    private $longt;

    /**
     * @var string
     *
     * @ORM\Column(name="distAU", type="decimal", precision=11, scale=9)
     */
    private $distAU;


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
     * Set longt
     *
     * @param string $longt
     *
     * @return Ceres
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
     * Set distAU
     *
     * @param string $distAU
     *
     * @return Ceres
     */
    public function setDistAU($distAU)
    {
        $this->distAU = $distAU;

        return $this;
    }

    /**
     * Get distAU
     *
     * @return string
     */
    public function getDistAU()
    {
        return $this->distAU;
    }
}

