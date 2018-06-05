<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dates
 *
 * @ORM\Table(name="Dates")
 * @ORM\Entity
 */
class Dates
{
    /**
     * @var string
     *
     * @ORM\Column(name="dates", type="string", length=11, nullable=false)
     */
    private $dates;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set dates
     *
     * @param string $dates
     *
     * @return Dates
     */
    public function setDates($dates)
    {
        $this->dates = $dates;

        return $this;
    }

    /**
     * Get dates
     *
     * @return string
     */
    public function getDates()
    {
        return $this->dates;
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
