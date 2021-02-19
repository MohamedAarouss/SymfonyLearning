<?php

namespace App\Controller;


use App\Entity\StatusDisease;
use App\Repository\DiseaseRepository;
use App\Repository\StatusDiseaseRepository;
use App\Repository\TreatmentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index" )
     */
    public function index(
        UserRepository $userRepository,
        StatusDiseaseRepository $statusDiseaseRepository,
        DiseaseRepository $diseaseRepository,
        TreatmentRepository $treatmentRepository
    )
    {
        $users = $userRepository->findBy([], ['username' => 'ASC']);
        $statusDisease = $statusDiseaseRepository->findBy([]);
        $diseases = $diseaseRepository->findBy([]);
        $treatments = $treatmentRepository->findBy([]);

        return $this->render('home/index.html.twig',
            [
                'users' => $users,
                'statusDiseases' => $statusDisease,
                'diseases' => $diseases,
                'treatments' => $treatments
            ]
        );
    }
}
