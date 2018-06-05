<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * General
 *
 * @ORM\Table(name="General", uniqueConstraints={@ORM\UniqueConstraint(name="planet", columns={"planet"})})
 * @ORM\Entity
 */
class General
{
    /**
     * @var string
     *
     * @ORM\Column(name="planet", type="string", length=20, nullable=false)
     */
    private $planet;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_id", type="integer", nullable=false)
     */
    private $maxId;

    /**
     * @var string
     *
     * @ORM\Column(name="min_AU", type="decimal", precision=11, scale=9, nullable=false)
     */
    private $minAu;

    /**
     * @var string
     *
     * @ORM\Column(name="max_AU", type="decimal", precision=11, scale=9, nullable=false)
     */
    private $maxAu;

    /**
     * @var string
     *
     * @ORM\Column(name="avg_AU", type="decimal", precision=11, scale=9, nullable=false)
     */
    private $avgAu;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set planet
     *
     * @param string $planet
     *
     * @return General
     */
    public function setPlanet($planet)
    {
        $this->planet = $planet;

        return $this;
    }

    /**
     * Get planet
     *
     * @return string
     */
    public function getPlanet()
    {
        return $this->planet;
    }

    /**
     * Set maxId
     *
     * @param integer $maxId
     *
     * @return General
     */
    public function setMaxId($maxId)
    {
        $this->maxId = $maxId;

        return $this;
    }

    /**
     * Get maxId
     *
     * @return integer
     */
    public function getMaxId()
    {
        return $this->maxId;
    }

    /**
     * Set minAu
     *
     * @param string $minAu
     *
     * @return General
     */
    public function setMinAu($minAu)
    {
        $this->minAu = $minAu;

        return $this;
    }

    /**
     * Get minAu
     *
     * @return string
     */
    public function getMinAu()
    {
        return $this->minAu;
    }

    /**
     * Set maxAu
     *
     * @param string $maxAu
     *
     * @return General
     */
    public function setMaxAu($maxAu)
    {
        $this->maxAu = $maxAu;

        return $this;
    }

    /**
     * Get maxAu
     *
     * @return string
     */
    public function getMaxAu()
    {
        return $this->maxAu;
    }

    /**
     * Set avgAu
     *
     * @param string $avgAu
     *
     * @return General
     */
    public function setAvgAu($avgAu)
    {
        $this->avgAu = $avgAu;

        return $this;
    }

    /**
     * Get avgAu
     *
     * @return string
     */
    public function getAvgAu()
    {
        return $this->avgAu;
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
