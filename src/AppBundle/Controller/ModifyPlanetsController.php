<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ModifyPlanetsController extends Controller
{

    /**
     * @Route("/getDataFromPlanets")
     */
    public function getDataFromPlanetsAction(Request $request)
    {
        $loadExternal = true;

        if ($loadExternal) {
            $w_names = $request->request->get('names');
        } else {
            $w_names = explode(',', 'Moon,Mercury,Venus,Sun,Mars,Ceres,Jupiter,Saturn,Uranus,Neptune,Pluto');
        }

        if ($loadExternal) {
            $w_nr = $request->request->get('nr');
        } else {
            $w_nr = 1;
        }

        if ($loadExternal) {
            $w_date = $request->request->get('date');
        } else {
            $w_date = '';
        }

        if ($loadExternal) {
            $w_namePlanet = $request->request->get('namePlanet');
        } else {
            $w_namePlanet = '';
        }

        if ($loadExternal) {
            $w_anglePlanet = $request->request->get('anglePlanet');
        } else {
            $w_anglePlanet = -1;
        }


        $arr = $w_names;
        $day_nr = $w_nr;
        $datePosted = $w_date;
        $namePlanet = $w_namePlanet;
        $anglePlanet = $w_anglePlanet;

        $empty_date = true;
        $currPlanet = null;
        $test = [];

        $arrResult = [];

        if (
            null !== $datePosted
            && !empty($datePosted)
        ) {
            $empty_date = false;
        }


        if (null !== ($namePlanet)
            && $anglePlanet != -1) {

            $currPlanet = $this->get('app.planet_dql', $namePlanet);

            $currPlanet->getDate($day_nr);
            $test[] = 'Przesunięto ' . genetivus($currPlanet->getName());
            $test[] = 'od ' . ceil($currPlanet->getLongt()) . "° ("
                . $currPlanet->getDate() . ") ";
            $day_nr = $currPlanet->askDailyPlanet($anglePlanet,
                $day_nr);
            $test[] = 'do ' . ceil($currPlanet->getLongt()) . "° ("
                . $currPlanet->getDate() . ")";
            $currPlanet = null;
        }
//                $currPlanet->getName()]);
        $jason2 = [];
        foreach ($arr as $planet) {
            $currPlanet = $this->get('app.planet_dql');
            $currPlanet->setName($planet);
            $jason2[] = $currPlanet->getName();
            if (!count($arrResult)) {
                if (!$empty_date) {
                    $day_nr = $currPlanet->searchDate($datePosted);
                }
                $arrResult[] = $currPlanet->getDate($day_nr);
                $arrResult[] = $day_nr;
                $jason2[] = $day_nr;
            }
            $arr = [];
            $arr[0] = ceil($currPlanet->getLongt($day_nr));
            $arr[1] = $currPlanet->getDistance();
            $arrResult[] = $arr;

            $currPlanet = null;
        }

        $arrResult[] = $test;
//        return new JsonResponse(['dziala']);
        if ($loadExternal) {
            return new JsonResponse($arrResult);
        } else {
            return $this->render('ModifyPlanets/get_data_from_planets.html.twig',
                ['wyniki' => json_encode($arrResult),
                    'jasons' => $jason2
                ]
            );
        }
    }
    private function genetivus($name) {
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

}
