<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Formation;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
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
    public function show(Formation $formation, Request $request, ContactNotification $notification ): Response
    {

        $contact = new Contact();
        // $contact->setFormation($formation);
        $form = $this->createForm(ContactType::class, $contact);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
                $notification->notify($contact);  
                $this->addFlash('success', 'Votre message a bien été envoyé.');
                /*return $this->redirectToRoute('/{id}');*/
        }
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            'form' => $form->createView()
        ]);
    }
}
