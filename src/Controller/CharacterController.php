<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/character")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class CharacterController extends AbstractController
{
    /**
     * @Route("/", name="character_index", methods={"GET"})
     */
    public function index(CharacterRepository $characterRepository): Response
    {
        return $this->render('character/index.html.twig', [
            'characters' => $characterRepository->findAll(),
        ]);
    }

    /**
     *
     * @Route("/{id}/show", name="character_show", methods={"GET"})
     */
    public function show(Character $character, CharacterRepository $characterRepository): Response
    {
        if($character->getAge() < 25){
            if($this->isGranted('ROLE_SUPER_ADMIN') === false){
                $this->addFlash('danger', 'Vous ne pouvez accéder à ce personnage');
                return $this->redirect($this->generateUrl('home'));
            }
        }

        return $this->render('character/show.html.twig', [
            'characters' => $characterRepository->findAll(),
            'character' => $character
        ]);
    }
}
