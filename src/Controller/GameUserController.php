<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameUser;
use App\Form\GameUserType;
use App\Repository\GameUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/game-user")
 *
 * @IsGranted("ROLE_USER")
 */
class GameUserController extends AbstractController
{
    /**
     * @Route("/", name="game_user_index", methods={"GET"})
     */
    public function index(GameUserRepository $gameUserRepository): Response
    {
        return $this->render('game_user/index.html.twig', [
            'game_users' => $gameUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="game_user_new", methods={"GET","POST"}, defaults={"id":null}, requirements={"id":"\d"})
     */
    public function new(Request $request, Game $game = null): Response
    {
        $gameUser = new GameUser();
        $form = $this->createForm(GameUserType::class, $gameUser, ['game' => $game]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gameUser);
            $entityManager->flush();

            if(isset($game)){
                $this->addFlash('success', "Great you are in the game ". $game->getName());
                return $this->redirectToRoute('game_show', ['id'=> $game->getId()]);
            }

            return $this->redirectToRoute('game_user_index');
        }

        return $this->render('game_user/new.html.twig', [
            'game_user' => $gameUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_user_show", methods={"GET"})
     */
    public function show(GameUser $gameUser): Response
    {
        return $this->render('game_user/show.html.twig', [
            'game_user' => $gameUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GameUser $gameUser): Response
    {
        $form = $this->createForm(GameUserType::class, $gameUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_user_index');
        }

        return $this->render('game_user/edit.html.twig', [
            'game_user' => $gameUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GameUser $gameUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_user_index');
    }
}
