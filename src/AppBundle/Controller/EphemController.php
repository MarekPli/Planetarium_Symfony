<?php

namespace AppBundle\Controller;
use Doctrine\ORM\EntityManager;

use AppBundle\Service\PlanetDQL;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class EphemController extends Controller
{
    private function makeFormPlanet($planet)
    {
        return $this->createFormBuilder($planet)
            ->add('id', IntegerType::class, $planet->getId())
            ->add('longt', TextType::class, $planet->getLongt())
            ->add('distau', TextType::class, $planet->getDistau())
            ->add('save', SubmitType::class, array('label' => 'Czytaj',
                'attr' => ['style' => 'color:green;width:150px;margin:5px 5px;
            font-size:20px;height:40px']
            ))
            ->getForm();
    }

    /**
     * @Route("/", name="ephemerids")
     */
    public function indexAction(Request $request)
    {
        return $this->render('ephem/index.html.twig');
    }

    private function repoPlanet($repoPlanet, $nr)
    {
        $planet['tab'] = $this->getDoctrine()
            ->getRepository('AppBundle:' . $repoPlanet)
            ->find($nr);
        $planet['name'] = $repoPlanet;

        return $planet;
    }


    /**
     * @Route("/repo", name="repo_test")
     */
    public function repoAction(Request $request)
    {
        $nr = 1;
        $planets = [];

//        $cereses = $this->getDoctrine()
//         ->getRepository('AppBundle:Ceres')
//         ->findAll();
//        $planets[] = $cereses[$nr];


        $planets[] = $this->repoPlanet('Ceres', $nr);
        $planets[] = $this->repoPlanet('Jupiter', $nr);
        $planets[] = $this->repoPlanet('Mars', $nr);
        $planets[] = $this->repoPlanet('Mercury', $nr);
        $planets[] = $this->repoPlanet('Moon', $nr);
        $planets[] = $this->repoPlanet('Neptune', $nr);
        $planets[] = $this->repoPlanet('Pluto', $nr);
        $planets[] = $this->repoPlanet('Saturn', $nr);
        $planets[] = $this->repoPlanet('Sun', $nr);
        $planets[] = $this->repoPlanet('Uranus', $nr);
        $planets[] = $this->repoPlanet('Venus', $nr);

//        $form = $this->makeFormPlanet($cereses[0]);

        $venus = $this->get('app.planet_dql');

        return $this->render('ephem/demo.html.twig',
            ['planets' => $planets,
                'venus' => $venus,
                'venusy' =>
//                $venus->searchDate('03.01.1970')
//                $venus->getMaxCount()
//                $venus->getLongt(7)
//                $venus->getDistAU()
//                    $venus->getDistance()
//                    $venus->readAllPlanets()
//                $venus->askDailyPlanet(1,6 1) // sprawdzić później
            ]);

    }
}
