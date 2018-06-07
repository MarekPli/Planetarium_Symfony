<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 06.06.2018
 * Time: 14:48
 */

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class PlanetDQL
{
    private $name;
    public $curr_id;
    private $max_au;
    private $min_au;
    private $avg_au;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
//        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        $this->curr_id = 1;
        $this->max_au = $this->getSizesBase('MaxAu');
        $this->min_au = $this->getSizesBase('MinAu');
        $this->avg_au = $this->getSizesBase('AvgAu');
    }

    public function getCurrId()
    {
        return $this->curr_id;
    }

    public function getMaxId()
    {
        return $this->max_id;
    }

    public function getMinAu()
    {
        return $this->min_au;
    }

    public function getMaxAu()
    {
        return $this->max_au;
    }

    public function getAvgAu()
    {
        return $this->avg_au;
    }

//    private function readBDRow($table = 0) {
//        if (!$table) {
//            $table = $this->name;
//        }
//        $query = "SELECT * FROM " .$table. " WHERE id = "
//            . $this->curr_id;
//        $stmt = self::$conn->query($query);
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        return $result;
//    }
    private function readBDRow($table = 0)
    {
        if (!$table) {
            $table = $this->name;
        }
//        $query = "SELECT * FROM " .$table. " WHERE id = "
//            . $this->curr_id;

        $result = $this->em
            ->getRepository('AppBundle:' . $table)
            ->find($this->curr_id);


//        $stmt = self::$conn->query($query);
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


//    private function getSizesBase($column) {
//        $query = "SELECT * FROM General WHERE planet = "
//            . "'" .$this->name. "'";
//        $stmt = self::$conn->query($query);
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        return $result[$column];
//    }

    private function getSizesBase($column)
    {
        $row = $this->em
            ->getRepository('AppBundle:General')
            ->findOneByPlanet($this->name);
//            ->findAll();

//        $query = "SELECT * FROM General WHERE planet = "
//            . "'" .$this->name. "'";
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        return $array[$column];
        $methodName = 'get' . $column;
        return $row->$methodName();
    }

    public function searchDate($date)
    {
//        $query = "SELECT * FROM " . "Dates" . " WHERE dates= '"
//            . $date . "'";
//        $stmt = self::$conn->query($query);
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        return $result['id'];

        $row = $this->em
            ->getRepository('AppBundle:Dates')
            ->findOneByDates($date);
        return $row->getId();
    }

    public function getMaxCount() {
//        $query = "SELECT count(*) FROM " .$this->name;
//        $stmt = self::$conn->query($query);
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        return $result['count(*)'];
        $rows = $this->em
            ->getRepository('AppBundle:' . $this->name)
            ->findAll();
        return count($rows);
    }

    // public function getDistAUInfo($operator) - do tworzenia bazy

    public function askDailyPlanet($newAngle, $nr) {
        $currAngle = $this->getLongt();
        if ($currAngle < $newAngle &&  ($newAngle - $currAngle) <=180 ) {
//            echo "Kąt rośnie, naprzód<br>";
//            $query = "SELECT * FROM " . $this->getName() .
//                " WHERE id > "
//                . $nr
//                . " AND longt > " . $newAngle
//                . " ORDER BY id"
//                . " limit 1";
//            $rows = $this->em
//                ->getRepository('AppBundle:' . $this->name)
//                ->finOneBy();

            $query = "SELECT p FROM " . 'AppBundle:' . $this->name .
            " WHERE p.id > " . $nr .
            " AND p.longt > " . $newAngle .
            " ORDER BY p.id";

        } elseif ($currAngle < $newAngle &&  ($newAngle - $currAngle) >180 ) {
//            echo "Kąt rośnie, wstecz<br>";

            $query = "SELECT p FROM " . 'AppBundle:' . $this->name .
                " WHERE p.id < " . $nr .
                " AND p.longt > " . $currAngle .
                " AND p.longt >= " . $newAngle .
                " ORDER BY p.id DESC"
//                . " limit 1"
            ;
        } elseif ($currAngle > $newAngle &&  ($currAngle - $newAngle) >180) {
//            echo "Kąt maleje, naprzód<br>";
            $query = "SELECT p FROM " . 'AppBundle:' . $this->name .
                " WHERE p.id > " . $nr .
                " AND p.longt < " . $currAngle .
                " AND p.longt > " . $newAngle .
                " AND p.longt <= " . (ceil($newAngle) +1) .
                " ORDER BY p.id"
//                . " limit 1"
                ;


        } elseif  ($currAngle > $newAngle && ($currAngle - $newAngle) <= 180) {
//            echo "Kąt maleje, wstecz<br>";

            $query = "SELECT p FROM " . 'AppBundle:' . $this->name .
                " WHERE p.id < " . $nr .
                " AND p.longt < " . $currAngle .
                " AND p.longt > " . $newAngle .
                " AND p.longt <= " . (ceil($newAngle) +1) .
                " ORDER BY p.id DESC"
//               . " limit 1"
            ;
        }
        $query = $this->em->createQuery($query);
        $result = $query->getResult();
        return $query;
        $this->curr_id = $result.getId();
        return $this->getCurrId();

    }
    public function readAllPlanets(){

        $names = [];
        $results = $this->em
            ->getRepository('AppBundle:General')
            ->findAll();
        foreach ($results as $result) {
            $names[] = $result->getPlanet();
        }
        return $names;
    }

    public function getDate($id = 0)
    {
        if ($id) {
            $this->curr_id = $id;
        }
        $row = $this->readBDRow('Dates');
        return $row->getDates();
    }


    public function getLongt($id = 0){
        if ($id) {
            $this->curr_id = $id;
        }
        $row = $this->readBDRow();
        return $row->getLongt();
    }
    public function getDistAU() {
        $row = $this->readBDRow();
        return $row->getDistAU();
    }

    public function getDistance(){
        $distAU = $this->getDistAU();
        $dist_X = $this->max_au - $this->min_au;
        $dist_x = $distAU - $this->min_au;
        return ($dist_x / $dist_X);
    }

}