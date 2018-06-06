<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mercury
 *
 * @ORM\Table(name="Mercury")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MercuryRepository")
 */
class Mercury
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * Get id
     *
     * @return integer
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
     * @return Mercury
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
     * @return Mercury
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
}
