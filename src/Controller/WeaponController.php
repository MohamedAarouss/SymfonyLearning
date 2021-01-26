<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Weapon;
use App\Entity\WeaponType as WeaponTypeEntity;
use App\Event\AppEvent;
use App\Event\WeaponEvent;
use App\Form\WeaponType;
use App\Repository\WeaponRepository;
use App\Security\Voter\AppAccess;
use App\Service\Weapon\Load;
use App\Service\Weapon\Reload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/weapon")
 * @IsGranted("ROLE_USER")
 */
class WeaponController extends AbstractController
{
    /**
     * @Route("/", name="weapon_index", methods={"GET"})
     */
    public function index(WeaponRepository $weaponRepository): Response
    {
        return $this->render(
            'weapon/index.html.twig',
            [
                'weapons' => $weaponRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new/{game}", name="weapon_new", methods={"GET","POST"}, requirements={"game":"\d"})
     */
    public function new(
        Request $request,
        Game $game = null,
        EventDispatcherInterface $dispatcher,
        WeaponEvent $weaponEvent
    ): Response {
        $weapon = new Weapon();
        $form = $this->createForm(WeaponType::class, $weapon, ['game' => $game]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $weaponEvent->setWeapon($weapon);
            $dispatcher->dispatch($weaponEvent, 'weapon.create');
            //$dispatcher->dispatch($weaponEvent, 'weapon.create_controller'); Ou bien


            if ($game !== null) {

                $this->addFlash('success', 'Ajout de l\'arme '.$weapon->getName().' réussit :)');

                return $this->redirectToRoute('game_show', ['id' => $game->getId()]);
            }

            return $this->redirectToRoute('weapon_index');
        }

        return $this->render(
            'weapon/new.html.twig',
            [
                'weapon' => $weapon,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="weapon_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Weapon $weapon): Response
    {
        if ($this->isGranted(AppAccess::WEAPON_SHOW, $weapon) === false) {
            $this->addFlash('error', 'you cannot access to this object !');

            return $this->redirectToRoute('weapon_index');
        }

        return $this->render(
            'weapon/show.html.twig',
            [
                'weapon' => $weapon,
            ]
        );
    }

    /**
     * @Route("/{id}/edit/{game}", name="weapon_edit", methods={"GET","POST"}, requirements={"game":"\d"})
     */
    public function edit(Request $request, Weapon $weapon, Game $game = null): Response
    {

        $this->denyAccessUnlessGranted(AppAccess::WEAPON_EDIT, $weapon);

        $form = $this->createForm(WeaponType::class, $weapon, ['game' => $game]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if ($game !== null) {

                $this->addFlash('success', 'Modification de l\'arme '.$weapon->getName().' réussit :)');

                return $this->redirectToRoute('game_show', ['id' => $game->getId()]);
            }

            return $this->redirectToRoute('weapon_index');
        }

        return $this->render(
            'weapon/edit.html.twig',
            [
                'weapon' => $weapon,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="weapon_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Weapon $weapon): Response
    {
        $this->denyAccessUnlessGranted(AppAccess::WEAPON_DELETE, $weapon);

        if ($this->isCsrfTokenValid('delete'.$weapon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($weapon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('weapon_index');
    }


    /**
     * @Route("/load/{id}/{load}/{game}", name="weapon_load", methods={"GET"}, requirements={"id"="\d+", "load"="\d"})
     */
    public function load(Weapon $weapon, $load = 1, $game = null, EventDispatcherInterface $dispatcher,
        WeaponEvent $weaponEvent): Response
    {
        //$this->addFlash('success', 'Crick Crick');

        if ($this->isGranted(AppAccess::WEAPON_SHOW, $weapon) === false) {
            $this->addFlash('danger', 'you cannot load a weapon that does not belong to you !');

            if (isset($game)) {
                return $this->redirectToRoute('game_show', ['id' => $weapon->getGame()->getId()]);
            } else {
                return $this->redirectToRoute('user_profile');
            }
        }

        $weaponEvent->setLoad(boolval($load));
        $weaponEvent->setWeapon($weapon);
        $dispatcher->dispatch($weaponEvent, AppEvent::WeaponLoad);

        if (isset($game)) {
            return $this->redirectToRoute('game_show', ['id' => $weapon->getGame()->getId()]);
        } else {
            return $this->redirectToRoute('user_profile');
        }
    }

    /**
     * @Route("/reload/{id}", name="weapon_reload", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function reload(Weapon $weapon, Reload $reload): Response
    {

        if ($this->isGranted(AppAccess::WEAPON_SHOW, $weapon) === false) {
            $this->addFlash('danger', 'you cannot reload a weapon that does not belong to you !');

            return $this->redirectToRoute('game_show', ['id' => $weapon->getGame()->getId()]);
        }

        $reload->reload($weapon);

        return $this->redirectToRoute('game_show', ['id' => $weapon->getGame()->getId()]);

    }

}
