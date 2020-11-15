<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Repository\GameRepository;
use App\Repository\GameUserRepository;
use App\Repository\UserRepository;
use App\Repository\WeaponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index" )
     */
    public function index()
    {
        if($this->isGranted('ROLE_USER') === true){
            return $this->redirect($this->generateUrl('home_logued_index'));
        }

        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/logued/", name="home_logued_index" )
     *
     * @IsGranted("ROLE_USER")
     */
    public function indexLogued(WeaponRepository $weaponRepository)
    {
        return $this->render('home/index_logued.html.twig',
            ['weapons' => $weaponRepository->findByWeaponTypeNameAndWeaponScarcity()
        ]
        );
    }

}
