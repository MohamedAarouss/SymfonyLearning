<?php

namespace App\Controller;

use App\Entity\ActionUser;
use App\Form\ActionUserType;
use App\Repository\ActionUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/action/user")
 */
class ActionUserController extends AbstractController
{
    /**
     * @Route("/", name="action_user_index", methods={"GET"})
     */
    public function index(ActionUserRepository $actionUserRepository): Response
    {
        return $this->render('action_user/index.html.twig', [
            'action_users' => $actionUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="action_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $actionUser = new ActionUser();
        $form = $this->createForm(ActionUserType::class, $actionUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actionUser);
            $entityManager->flush();

            return $this->redirectToRoute('action_user_index');
        }

        return $this->render('action_user/new.html.twig', [
            'action_user' => $actionUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_user_show", methods={"GET"})
     */
    public function show(ActionUser $actionUser): Response
    {
        return $this->render('action_user/show.html.twig', [
            'action_user' => $actionUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="action_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ActionUser $actionUser): Response
    {
        $form = $this->createForm(ActionUserType::class, $actionUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('action_user_index');
        }

        return $this->render('action_user/edit.html.twig', [
            'action_user' => $actionUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ActionUser $actionUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actionUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actionUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('action_user_index');
    }
}
