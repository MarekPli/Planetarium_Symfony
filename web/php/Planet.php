<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 19.05.2018
 * Time: 10:59
 */

include_once __DIR__ . '/readDB.php';

class Planet {

    static $conn = null;
//    private $conn;
    private $name;
    public $curr_id;
    public $max_id;
    public $min_id;
    public $avg_id;

    public function __construct($name)
    {
        if (!self::$conn) {
//            echo "Otwieram bazę<br>";
            self::$conn = myOpenDB();
        }
        $this->name = $name;
        $this->curr_id = 1;
        $this->max_au = $this->getSizesBase('max_AU');
        $this->min_au = $this->getSizesBase('min_AU');
        $this->avg_au = $this->getSizesBase('avg_AU');
    }

    public function getName()
    {
        return $this->name;
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

    private function readBDRow($table = 0) {
        if (!$table) {
            $table = $this->name;
        }
        $query = "SELECT * FROM " .$table. " WHERE id = "
            . $this->curr_id;
        $stmt = self::$conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    private function getSizesBase($column) {
        $query = "SELECT * FROM General WHERE planet = "
            . "'" .$this->name. "'";
        $stmt = self::$conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result[$column];
    }
    public function searchDate ($date) {
        $query = "SELECT * FROM " ."Dates". " WHERE dates= '"
         . $date . "'";
        $stmt = self::$conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

    public function getMaxCount() {
        $query = "SELECT count(*) FROM " .$this->name;
        $stmt = self::$conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count(*)'];
    }
    public function getDistAUInfo($operator) {
        // działa dla: MIN, MAX, AVG
        $query = "SELECT  " .$operator. "(distAU) FROM " .$this->name;
        $stmt = self::$conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result[$operator . '(distAU)'];
    }
    public function askDailyPlanet($newAngle, $nr) {
//        $curAngle = -1;
//        while ($curAngle < $angle ) {
//            $nr++;
//            $curAngle = ceil ($this->getLongt($nr));
//        }
//        return $this->getCurrId();
        $currAngle = $this->getLongt();
        if ($currAngle < $newAngle &&  ($newAngle - $currAngle) <=180 ) {
//            echo "Kąt rośnie, naprzód<br>";
            $query = "SELECT * FROM " . $this->getName() . " WHERE id > "
                . $nr
                . " AND longt > " . $newAngle
                . " ORDER BY id"
                . " limit 1";
        } elseif ($currAngle < $newAngle &&  ($newAngle - $currAngle) >180 ) {
//            echo "Kąt rośnie, wstecz<br>";
            $query = "SELECT * FROM " . $this->getName() . " WHERE id < "
                . $nr
                . " AND longt > " . $currAngle
                . " AND longt < " . $newAngle
                . " AND longt >= " . (ceil($newAngle) - 1)
                . " ORDER BY id DESC"
                . " limit 1";

        } elseif ($currAngle > $newAngle &&  ($currAngle - $newAngle) >180) {
//            echo "Kąt maleje, naprzód<br>";
            $query = "SELECT * FROM " . $this->getName() . " WHERE id > "
                . $nr
                . " AND longt < " . $currAngle
                . " AND longt > " . $newAngle
                . " AND longt <= " . (ceil($newAngle) +1)
                . " ORDER BY id"
                . " limit 1";
        } elseif  ($currAngle > $newAngle && ($currAngle - $newAngle) <= 180) {
//            echo "Kąt maleje, wstecz<br>";
            $query = "SELECT * FROM " . $this->getName() . " WHERE id < "
                . $nr
                . " AND longt < " . $currAngle
                . " AND longt > " . $newAngle
                . " AND longt <= " . (ceil($newAngle) + 1)
                . " ORDER BY id DESC"
                . " limit 1";
        }

        $stmt = self::$conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->curr_id = $result['id'];
        return $this->getCurrId();
    }

    public static function readAllPlanets(){
        if (!self::$conn) {
//            echo "Otwieram bazę<br>";
            self::$conn = myOpenDB();
        }
        $query = "SELECT * FROM " . "General";
        $stmt = self::$conn->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = $row['planet'];
        }
        return $result;
    }

    public function getDate($id = 0)
    {
        if ($id) {
            $this->curr_id = $id;
        }
        $row = $this->readBDRow('Dates');
        return $row['dates'];
    }

    public function getLongt($id = 0){
        if ($id) {
            $this->curr_id = $id;
        }
        $row = $this->readBDRow();
        return $row['longt'];
    }
    
    public function getDistAU() {
        $row = $this->readBDRow();
        return $row['distAU'];
    }
    public function getDistance(){
        // $this->min_au;
        // $this->max_au;
        // $this->avg_au;
        
        $distAU = $this->getDistAU();
        $dist_X = $this->max_au - $this->min_au;
        $dist_x = $distAU - $this->min_au;
        return ($dist_x / $dist_X);
    }
};

