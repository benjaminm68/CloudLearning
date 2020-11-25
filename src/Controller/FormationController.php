<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Formation;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="formation_index")
     */
    public function index(): Response
    {

        $formations = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->getAll();

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/{id}", name="formation_show", methods="GET")
     */
    public function show(Formation $formation): Response
    {

        $contact = new Contact();
        // $contact->setFormation($formation);
        $form = $this->createForm(ContactType::class, $contact);

        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            'form' => $form->createView()
        ]);
    }
}
