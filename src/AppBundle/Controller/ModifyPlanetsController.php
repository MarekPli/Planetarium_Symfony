<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ModifyPlanetsController extends Controller
{



    /**
     * @Route("/getDataFromPlanets")
     */
    public function getDataFromPlanetsAction()
    {


















        return $this->render('AppBundle:ModifyPlanets:get_data_from_planets.html.twig', array(
            // ...
        ));
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
