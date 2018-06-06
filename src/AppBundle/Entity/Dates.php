<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dates
 *
 * @ORM\Table(name="dates")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DatesRepository")
 */
class Dates
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
     * @ORM\Column(name="dates", type="string", length=11)
     */
    private $dates;


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
}
