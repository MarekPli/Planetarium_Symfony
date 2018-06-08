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
    static public $arrDBRow = array();
    private $em;
    public $test = array();

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
//        self::$arrDBRow = [];
        $this->test[] = 'konstruktor';
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
    public function readme() {
        if (!array_key_exists($this->curr_id, self::$arrDBRow)) {
            $this->test[] = "Readme nie było";
            $query = $this->em
                ->createQuery(
                    'SELECT p'
                    . ' FROM AppBundle:' . $this->name . ' p'
                    . ' WHERE p.id >= ' . $this->curr_id
                    . ' AND p.id <' . ($this->curr_id + 1000)
                    . ' ORDER BY p.id ASC'
                );
            $results = $query->getResult();
//            self::$arrDBRow = [];
            foreach ($results as $result) {
                self::$arrDBRow[$result->getId()] = $result;
            }
        } else {
            $this->test[] = "Readme było";

        }
        $this->test[] = "Readme end";
        $s = self::$arrDBRow[$this->curr_id];
        return $s;

//        if (array_key_exists(7, self::$arrDBRow)) {
//            return self::$arrDBRow[7]->getLongt();
//        }
//        else {
//            return 'nie ma...';
//        }
    }
    private function readBDRow($table = 0)
    {
        if (!$table) {
            $table = $this->name;
        }
//        $query = "SELECT * FROM " .$table. " WHERE id = "
//            . $this->curr_id;
//        $arr = array_keys($this->arrDBRow);
//        if (in_array($this->curr_id, $arr)) {
        if (!array_key_exists($table, self::$arrDBRow)) {
            self::$arrDBRow[$table] = [];
        }
        if (array_key_exists($this->curr_id, self::$arrDBRow[$table])) {
            return self::$arrDBRow[$table][$this->curr_id];
        }
        $my_nr = 1;
        $query = $this->em
            ->createQuery(
                'SELECT p'
                . ' FROM AppBundle:' . $table . ' p'
                . ' WHERE p.id >= ' . ($this->curr_id)
                . ' AND p.id <' . ($this->curr_id + $my_nr)
                . ' ORDER BY p.id ASC'
            );
        $results = $query->getResult();

//        self::$arrDBRow[$table] = [];
        foreach ($results as $result) {
            self::$arrDBRow[$table][$result->getId()] = $result;
        }
        return self::$arrDBRow[$table][$this->curr_id];
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
        $table = 'General';
        if (!array_key_exists($table, self::$arrDBRow)) {
            self::$arrDBRow[$table] = [];
        }
        if (array_key_exists($this->name, self::$arrDBRow[$table])) {
            $row = self::$arrDBRow[$table][$this->name];
        } else {
            $row = $this->em
                ->getRepository('AppBundle:General')
                ->findOneByPlanet($this->name);
//            ->findAll();
//            foreach ($rows as $row) {
                self::$arrDBRow[$table][$this->name] = $row;
//            }
//        $query = "SELECT * FROM General WHERE planet = "
//            . "'" .$this->name. "'";
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        return $array[$column];
            $row = self::$arrDBRow[$table][$this->name];
        }
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
//        return $query;
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