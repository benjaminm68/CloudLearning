<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\AddStagiaireType;
use App\Form\AddStagiaireSessionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/stagiaire")
 */

class StagiaireController extends AbstractController
{

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/delete/{id}", name="stagiaire_delete")
     */
    public function delete(Stagiaire $stagiaire)
    {

        $em = $this->getDoctrine()->getManager();

        $em->remove($stagiaire);
        $em->flush();

        return $this->redirectToRoute('stagiaire_index');
    }


    /**
     * @Route("/", name="stagiaire_index")
     */
    public function index(): Response
    {

        $stagiaires = $this->getDoctrine()
            ->getRepository(Stagiaire::class)
            ->getAll();

        return $this->render('panel/panel-listeStagiaire.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    /**
     * @Route("/test", name="stagiaire_add_session")
     */
    public function stagiaireInSession(Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $manager): Response
    {

      
        $form = $this->createForm(AddStagiaireSessionType::class, $stagiaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($stagiaire);
            $manager->flush();

            return $this->redirectToRoute('stagiaire_index');
        }
        return $this->render('stagiaire/stagiaireSession.html.twig', [
            'AddStagiaireSessionType' => $form->createView(),
            'stagiaire' => $stagiaire
        ]);
    }



    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ajouter", name="stagiaire_add")
     * @Route("/edit{id}", name="stagiaire_edit")
     */
    public function addEdit(Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$stagiaire) {
            $stagiaire = new Stagiaire();
        }
        $form = $this->createForm(AddStagiaireType::class, $stagiaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($stagiaire);
            $manager->flush();

            return $this->redirectToRoute('stagiaire_index');
        }
        return $this->render('panel/panel-ajouterStagiaire.html.twig', [
            'AddStagiaireType' => $form->createView(),
            'editMode' => $stagiaire->getId() !== null,
            'stagiaire' => $stagiaire->getNom()
        ]);
    }

    /**
     * @Route("/{id}", name="stagiaire_show", methods="GET")
     */
    public function show(Stagiaire $stagiaire): Response
    {
        return $this->render('stagiaire/show.html.twig', ['stagiaire' => $stagiaire]);
    }
}
