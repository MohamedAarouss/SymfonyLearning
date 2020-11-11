<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use App\Security\Voter\VoterAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * @Route("/character")
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
     * @Route("/new", name="character_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($character);
            $entityManager->flush();

            return $this->redirectToRoute('character_index');
        }

        return $this->render('character/new.html.twig', [
            'character' => $character,
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/{id}/show", name="character_show", methods={"GET"})
     */
    public function show(Character $character, CharacterRepository $characterRepository): Response
    {
        //Sans Voter
        /*
        if($character->getAge() < 25){
            if($this->isGranted('ROLE_SUPER_ADMIN') === false){
                $this->addFlash('danger', 'Vous ne pouvez accéder à ce personnage');
                return $this->redirect($this->generateUrl('home'));
            }
        }
        */

        //Avec Voter
        if($this->isGranted(VoterAccess::CHARACTER_SHOW, $character) === false){
            $this->addFlash('danger', 'Vous ne pouvez accéder à ce personnage');
            return $this->redirect($this->generateUrl('home'));
        }


        return $this->render('character/show.html.twig', [
            'characters' => $characterRepository->findAll(),
            'character' => $character
        ]);
    }

    /**
     * @Route("/{id}/edit", name="character_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Character $character): Response
    {
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('character_index');
        }

        return $this->render('character/edit.html.twig', [
            'character' => $character,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="character_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Character $character): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('character_index');
    }

    /**
     * @Route("/{id}/addyears/", name="character_add_years", methods={"GET", "POST"})
     */
    public function addYears(Request $request, Character $character, ValidatorInterface $validator): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            $this->addFlash('danger', 'You are not allowed to increase a character\'s age');
            return $this->redirect($this->generateUrl('home'));
        }
        $form = $this->createAddYearsForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $character->setAge($character->getAge() + $data['years']);

            $errors = $validator->validate($character);

            if(count($errors) === 0){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($character);
                $entityManager->flush();
                $this->addFlash('success',  'Congratulation '. $character->getName() . ' have now '. $character->getAge() . ' Years !');

                return $this->redirectToRoute('character_index');
            }
            $this->addFlash('danger',  $character->getName() . 'can\'t have '. $character->getAge() . ' Years !');
        }

        return $this->render('character/add_years.html.twig', [
            'character' => $character,
            'form' => $form->createView()
        ]);
    }

    private function createAddYearsForm(){
        foreach(range(10,20) as $value){
            $values[$value] = $value;
        }
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add('years', ChoiceType::class, [
            'choices' => $values
        ]);
        $formBuilder->add('submit', SubmitType::class);
        return $formBuilder->getForm();
    }

}
