<?php

namespace App\Controller;

use App\Entity\Education;
use App\Repository\EducationRepository;

use App\Entity\Preschool;
use App\Repository\PreschoolRepository;

use App\Entity\HealthEducation;
use App\Repository\HealthEducationRepository;

use App\Entity\HealthEconomy;
use App\Repository\HealthEconomyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ProjectController extends AbstractController
{
    #[Route("/proj", name: "project")]
    public function project(): Response
    {

        return $this->render('project/proj_home.html.twig');
    }

    #[Route("/proj/references", name: "references")]
    public function references(): Response
    {

        return $this->render('project/proj_references.html.twig');
    }

    #[Route("/proj/about", name: "about_project")]
    public function aboutProject(): Response
    {
        return $this->render('project/proj_about.html.twig');
    }

    #[Route("/proj/about/database", name: "about_database")]
    public function aboutDatabase(): Response
    {
        return $this->render('project/proj_about_database.html.twig');
    }

    #[Route("/proj/health", name: "goal_three")]
    public function goalThree(
        HealthEducationRepository $healthEducationRepository,
        HealthEconomyRepository $healthEconomyRepository,
        ChartBuilderInterface $chartBuilder
    ): Response
    {
        $healthEduWomen = $healthEducationRepository
            ->findBy(array('gender' => 'women'));

        $healthEduMen = $healthEducationRepository
            -> findBy(array('gender' => 'men'));

        $healthEcoWomen = $healthEconomyRepository
            -> findBy(array('gender' => 'women'));

        $healthEcoMen = $healthEconomyRepository
        -> findBy(array('gender' => 'men'));

    $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
    $chart->setData([
        'labels' => ['Kvinnor', 'Män'],
        'datasets' => [
            [
                'label' => 'Förgymnasial',
                'type' => 'bar',
                'backgroundColor' => 'rgb(197, 25, 45, .4)',
                'borderColor' => 'rgb(197, 25, 45)',
                'tension' => 0.4,
                'data' => [$healthEduWomen[0]->getSelfRatedHealth(),
                           $healthEduMen[0]->getSelfRatedHealth(),
                        ],
            ],
            [
                'label' => 'Gymnasial',
                'type' => 'bar',
                'backgroundColor' => 'rgba(76, 159, 56, .4)',
                'borderColor' => 'rgba(76, 159, 56)',
                'tension' => 0.4,
                'data' => [$healthEduWomen[1]->getSelfRatedHealth(),
                           $healthEduMen[1]->getSelfRatedHealth()
                        ],
            ],
            [
                'label' => 'Eftergymnasial under 3 år',
                'type' => 'bar',
                'backgroundColor' => 'rgb(0, 76, 129, .4)',
                'borderColor' => 'rgb(0, 76, 129)',
                'tension' => 0.4,
                'data' => [$healthEduWomen[2]->getSelfRatedHealth(),
                           $healthEduMen[2]->getSelfRatedHealth()
                        ],
            ],
            [
                'label' => 'Eftergymnasial 3 år och över',
                'type' => 'bar',
                'backgroundColor' => 'rgba(1, 108, 184, .4)',
                'borderColor' => 'rgba(1, 108, 184)',
                'tension' => 0.4,
                'data' => [$healthEduWomen[3]->getSelfRatedHealth(),
                           $healthEduMen[3]->getSelfRatedHealth()
                        ],
            ],
        ],
    ]);
        $chart->setOptions([
        'scales' => [
            'y' => [
                'suggestedMin' => 0,
                'suggestedMax' => 100,
            ],
        ],
    ]);

    $chartEco = $chartBuilder->createChart(Chart::TYPE_LINE);
    $chartEco->setData([
        'labels' => ['Kvinnor', 'Män'],
        'datasets' => [
            [
                'label' => 'Förgymnasial',
                'type' => 'bar',
                'backgroundColor' => 'rgb(197, 25, 45, .4)',
                'borderColor' => 'rgb(197, 25, 45)',
                'tension' => 0.4,
                'data' => [$healthEcoWomen[0]->getNeededCare(),
                           $healthEcoMen[0]->getNeededCare(),
                        ],
            ],
            [
                'label' => 'Gymnasial',
                'type' => 'bar',
                'backgroundColor' => 'rgba(76, 159, 56, .4)',
                'borderColor' => 'rgba(76, 159, 56)',
                'tension' => 0.4,
                'data' => [$healthEcoWomen[1]->getNeededCare(),
                           $healthEcoMen[1]->getNeededCare()
                        ],
            ],
            [
                'label' => 'Eftergymnasial',
                'type' => 'bar',
                'backgroundColor' => 'rgb(0, 76, 129, .4)',
                'borderColor' => 'rgb(0, 76, 129)',
                'tension' => 0.4,
                'data' => [$healthEcoWomen[2]->getNeededCare(),
                           $healthEcoMen[2]->getNeededCare()
                        ],
            ],
        ],
    ]);
        $chartEco->setOptions([
        'scales' => [
            'y' => [
                'suggestedMin' => 0,
                'suggestedMax' => 8,
            ],
        ],
    ]);

    $data = [
        'chart' => $chart,
        'chartEco' => $chartEco
    ];

        return $this->render('project/proj_health.html.twig', $data);
    }

    #[Route("/proj/education", name: "goal_four")]
    public function goalFour(
        EducationRepository $educationRepository,
        PreschoolRepository $preschoolRepository,
        ChartBuilderInterface $chartBuilder
    ): Response
    {
        $twentyfifteenWomen = $educationRepository 
            ->findBy(array('gender' => 'women',
                         'year' => 2015));

        $twentynineteenWomen = $educationRepository 
            ->findBy(array('gender' => 'women',
                         'year' => 2019));

        $twentyfifteenMen = $educationRepository 
            ->findBy(array('gender' => 'men',
                         'year' => 2015));

        $twentynineteenMen = $educationRepository 
            ->findBy(array('gender' => 'men',
                         'year' => 2019));

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['Kvinnor 2015', 'Kvinnor 2019', 'Män 2015', 'Män 2019'],
            'datasets' => [
                [
                    'label' => 'Förgymnasial',
                    'type' => 'bar',
                    'backgroundColor' => 'rgb(197, 25, 45, .4)',
                    'borderColor' => 'rgb(197, 25, 45)',
                    'tension' => 0.4,
                    'data' => [$twentyfifteenWomen[0]->getPercentage(),
                               $twentynineteenWomen[0]->getPercentage(),
                               $twentyfifteenMen[0]->getPercentage(),
                               $twentynineteenMen[0]->getPercentage()
                            ],
                ],
                [
                    'label' => 'Gymnasial',
                    'type' => 'bar',
                    'backgroundColor' => 'rgba(76, 159, 56, .4)',
                    'borderColor' => 'rgba(76, 159, 56)',
                    'tension' => 0.4,
                    'data' => [$twentyfifteenWomen[1]->getPercentage(),
                               $twentynineteenWomen[1]->getPercentage(),
                               $twentyfifteenMen[1]->getPercentage(),
                               $twentynineteenMen[1]->getPercentage()
                            ],
                ],
                [
                    'label' => 'Eftergymnasial under 3 år',
                    'type' => 'bar',
                    'backgroundColor' => 'rgb(0, 76, 129, .4)',
                    'borderColor' => 'rgb(0, 76, 129)',
                    'tension' => 0.4,
                    'data' => [$twentyfifteenWomen[2]->getPercentage(),
                               $twentynineteenWomen[2]->getPercentage(),
                               $twentyfifteenMen[2]->getPercentage(),
                               $twentynineteenMen[2]->getPercentage()
                            ],
                ],
                [
                    'label' => 'Eftergymnasial 3 år och över',
                    'type' => 'bar',
                    'backgroundColor' => 'rgba(1, 108, 184, .4)',
                    'borderColor' => 'rgba(1, 108, 184)',
                    'tension' => 0.4,
                    'data' => [$twentyfifteenWomen[3]->getPercentage(),
                               $twentynineteenWomen[3]->getPercentage(),
                               $twentyfifteenMen[3]->getPercentage(),
                               $twentynineteenMen[3]->getPercentage()
                            ],
                ],
                [
                    'label' => 'Okänd',
                    'type' => 'bar',
                    'backgroundColor' => 'rgba(252, 195, 11, .4)',
                    'borderColor' => 'rgba(252, 195, 11)',
                    'tension' => 0.4,
                    'data' => [$twentyfifteenWomen[4]->getPercentage(),
                               $twentynineteenWomen[4]->getPercentage(),
                               $twentyfifteenMen[4]->getPercentage(),
                               $twentynineteenMen[4]->getPercentage()
                            ],
                ],
            ],
        ]);
            $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 50,
                ],
            ],
        ]);

        $twentyfifteenPreschool = $preschoolRepository 
        ->findBy(array('year' => 2015));

        $twentysixteenPreschool = $preschoolRepository 
        ->findBy(array('year' => 2016));

        $twentyseventeenPreschool = $preschoolRepository 
        ->findBy(array('year' => 2017));

        $twentyeightteenPreschool = $preschoolRepository 
        ->findBy(array('year' => 2018));

        $twentynineteenPreschool = $preschoolRepository 
            ->findBy(array('year' => 2019));

            $chartPreschool = $chartBuilder->createChart(Chart::TYPE_LINE);
            $chartPreschool->setData([
                'labels' => ['2015', '2016', '2017', '2018', '2019'],
                'datasets' => [
                    [
                        'label' => 'Förgymnasial',
                        'backgroundColor' => 'rgb(197, 25, 45, .4)',
                        'borderColor' => 'rgb(197, 25, 45)',
                        'tension' => 0.4,
                        'data' => [$twentyfifteenPreschool[0]->getPercentage(),
                                   $twentysixteenPreschool[0]->getPercentage(),
                                   $twentyseventeenPreschool[0]->getPercentage(),
                                   $twentyeightteenPreschool[0]->getPercentage(),
                                   $twentynineteenPreschool[0]->getPercentage()
                                ],
                    ],
                    [
                        'label' => 'Gymnasial',
                        'backgroundColor' => 'rgba(76, 159, 56, .4)',
                        'borderColor' => 'rgba(76, 159, 56)',
                        'tension' => 0.4,
                        'data' => [$twentyfifteenPreschool[1]->getPercentage(),
                                   $twentysixteenPreschool[1]->getPercentage(),
                                   $twentyseventeenPreschool[1]->getPercentage(),
                                   $twentyeightteenPreschool[1]->getPercentage(),
                                   $twentynineteenPreschool[1]->getPercentage()
                     ],
                    ],
                    [
                        'label' => 'Eftergymnasial',
                        'backgroundColor' => 'rgba(0, 76, 129, .4)',
                        'borderColor' => 'rgba(0, 76, 129)',
                        'tension' => 0.4,
                        'data' => [$twentyfifteenPreschool[2]->getPercentage(),
                                   $twentysixteenPreschool[2]->getPercentage(),
                                   $twentyseventeenPreschool[2]->getPercentage(),
                                   $twentyeightteenPreschool[2]->getPercentage(),
                                   $twentynineteenPreschool[2]->getPercentage()
                     ],
                    ],
                    [
                        'label' => 'Okänd',
                        'backgroundColor' => 'rgba(252, 195, 11, .4)',
                        'borderColor' => 'rgba(252, 195, 11)',
                        'tension' => 0.4,
                        'data' => [$twentyfifteenPreschool[3]->getPercentage(),
                                   $twentysixteenPreschool[3]->getPercentage(),
                                   $twentyseventeenPreschool[3]->getPercentage(),
                                   $twentyeightteenPreschool[3]->getPercentage(),
                                   $twentynineteenPreschool[3]->getPercentage()
                     ],
                    ],
                ],
            ]);
                $chartPreschool->setOptions([
                'scales' => [
                    'y' => [
                        'suggestedMin' => 40,
                        'suggestedMax' => 100,
                    ],
                ],
            ]);

        $data = [
            'chart' => $chart,
            'chartPreschool' => $chartPreschool
        ];

        return $this->render('project/proj_education.html.twig', $data);
    }
}
