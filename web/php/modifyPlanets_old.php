<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 20.05.2018
 * Time: 21:33
 */
// echo 'jestem';
function genetivus($name) {
    if ($name == 'Sun') {
        return "Słońce";
    } elseif ( $name == 'Moon') {
        return 'Księżyc';
    } elseif ( $name == 'Mercury') {
        return 'Mekurego';
    } elseif ( $name == 'Venus') {
        return 'Wenus';
    } elseif ( $name == 'Mars') {
        return 'Marsa';
    } elseif ( $name == 'Ceres') {
        return 'Ceres';
    } elseif ( $name == 'Jupiter') {
        return 'Jowisza';
    } elseif ( $name == 'Saturn') {
        return 'Saturna';
    } elseif ( $name == 'Uranus') {
        return 'Urana';
    } elseif ( $name == 'Neptune') {
        return 'Neptuna';
    } elseif ( $name == 'Pluto') {
        return 'Plutona';
    } else {
        return "BŁĄD DANYCH";
    }
}

include_once __DIR__ . '/Planet.php';
if (isset($_POST['nr'])) {
//    set_time_limit(0); // chyba niepotrzebne, program się może zawiesić i lepiej sygnalizować wtedy błąd
    $arrResult = [];
//    $arr = ['Moon', 'Mercury', 'Venus', 'Sun', 'Mars', 'Ceres', 'Jupiter',
//        'Saturn', 'Uranus', 'Neptune', 'Pluto'];

    $arr = $_POST['names']; // nazwy planet w kolejności dołączenia do tablicy
    $day_nr = $_POST['nr'];
    $empty_date = true;
    $currPlanet = null;
    $test = [];
    if (isset ($_POST['date']) && !empty($_POST['date'])) {
        $empty_date = false;
    }
    if (isset ($_POST['namePlanet']) && $_POST['anglePlanet'] != -1) {
        $currPlanet = new Planet($_POST['namePlanet']);
        $currPlanet->getDate($day_nr);
        $test[] = 'Przesunięto ' . genetivus($currPlanet->getName());
        $test[] = 'od ' . ceil ($currPlanet->getLongt()) . "° ("
            . $currPlanet->getDate() . ") ";
        $day_nr = $currPlanet->askDailyPlanet($_POST['anglePlanet'],
            $day_nr);
        $test[] = 'do ' . ceil ($currPlanet->getLongt() ). "° ("
            .  $currPlanet->getDate() . ")";
        $currPlanet = null;
    }
    foreach ($arr as $planet) {
        $currPlanet = new Planet($planet);
        if (!count($arrResult)) {
            if (!$empty_date) {
                $day_nr = $currPlanet->searchDate($_POST['date']);
            }
            $arrResult[] = $currPlanet->getDate($day_nr);
            $arrResult[] = $day_nr;
        }
        $arr = [];
        $arr[0] = ceil($currPlanet->getLongt($day_nr));
        $arr[1] = $currPlanet->getDistance();
        $arrResult[] = $arr;

        $currPlanet = null;
    }
    $arrResult[] = $test;
    echo json_encode($arrResult);
}