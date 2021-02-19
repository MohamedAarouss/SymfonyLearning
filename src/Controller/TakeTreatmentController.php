<?php

namespace App\Controller;

use App\Entity\TakeTreatment;
use App\Form\TakeTreatmentType;
use App\Repository\TakeTreatmentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/take/treatment")
 * @IsGranted("ROLE_USER")
 */
class TakeTreatmentController extends AbstractController
{
    /**
     * @Route("/", name="take_treatment_index", methods={"GET"})
     */
    public function index(TakeTreatmentRepository $takeTreatmentRepository): Response
    {
        return $this->render('take_treatment/index.html.twig', [
            'take_treatments' => $takeTreatmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="take_treatment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $takeTreatment = new TakeTreatment();
        $form = $this->createForm(TakeTreatmentType::class, $takeTreatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($takeTreatment);
            $entityManager->flush();

            return $this->redirectToRoute('take_treatment_index');
        }

        return $this->render('take_treatment/new.html.twig', [
            'take_treatment' => $takeTreatment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="take_treatment_show", methods={"GET"})
     */
    public function show(TakeTreatment $takeTreatment): Response
    {
        return $this->render('take_treatment/show.html.twig', [
            'take_treatment' => $takeTreatment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="take_treatment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TakeTreatment $takeTreatment): Response
    {
        $form = $this->createForm(TakeTreatmentType::class, $takeTreatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('take_treatment_index');
        }

        return $this->render('take_treatment/edit.html.twig', [
            'take_treatment' => $takeTreatment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="take_treatment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TakeTreatment $takeTreatment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$takeTreatment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($takeTreatment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('take_treatment_index');
    }
}
