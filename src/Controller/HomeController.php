<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class HomeController extends AbstractController
{
    /**
     * @Route("/{id}", name="home", defaults={"id":null}, requirements={"id":"\d"})
     */
    public function index($id = null)
    {
        //$this->addFlash('success', "coucou");

        if(isset($id)){
            return $this->render('home/index'.$id.'.html.twig');
        }else{
            return $this->render('home/index.html.twig');
        }
    }

    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/tp", name="tp")
     */
    public function tp()
    {
        return $this->render('home/tp.html.twig');
    }

}
