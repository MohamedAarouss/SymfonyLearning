<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Weapon;
use App\Entity\WeaponType as WeaponTypeEntity;
use App\Form\WeaponType;
use App\Repository\WeaponRepository;
use App\Security\Voter\AppAccess;
use App\Service\Weapon\Load;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render('weapon/index.html.twig', [
            'weapons' => $weaponRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{game}", name="weapon_new", methods={"GET","POST"}, requirements={"game":"\d"})
     */
    public function new(Request $request, Game $game = null): Response
    {
        $weapon = new Weapon();
        $form = $this->createForm(WeaponType::class, $weapon, ['game' => $game]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($weapon);
            $entityManager->flush();

            return $this->redirectToRoute('weapon_index');
        }

        return $this->render('weapon/new.html.twig', [
            'weapon' => $weapon,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="weapon_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Weapon $weapon): Response
    {
        if($this->isGranted(AppAccess::WEAPON_SHOW, $weapon) === false){
            $this->addFlash('error', 'you cannot access to this object !');
            return $this->redirectToRoute('weapon_index');
        }

        return $this->render('weapon/show.html.twig', [
            'weapon' => $weapon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="weapon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Weapon $weapon): Response
    {

        $this->denyAccessUnlessGranted(AppAccess::WEAPON_EDIT, $weapon);

        $options = [];
        $form = $this->createForm(WeaponType::class, $weapon, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('weapon_index');
        }

        return $this->render('weapon/edit.html.twig', [
            'weapon' => $weapon,
            'form' => $form->createView(),
        ]);
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
     * @Route("/load/{id}", name="weapon_load", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function load(Weapon $weapon, Load $load): Response
    {
        //$this->addFlash('success', 'Crick Crick');

        if($this->isGranted(AppAccess::WEAPON_SHOW, $weapon) === false){
            $this->addFlash('danger', 'you cannot load a weapon that does not belong to you !');
            return $this->redirectToRoute('user_profile');
        }

        $load->load($weapon);

        return $this->redirectToRoute('user_profile');
    }
}
