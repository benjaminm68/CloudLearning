<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use App\Form\AddStagiaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Normalement on écrit adminController <----


class PanelController extends AbstractController
{

   

    /**
     * @Route("/panel", name="panel_index")
     */
    public function index(): Response
    {

        $formations = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->getAll();

            $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->getAll();

            $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->getAll();

            $stagiaires = $this->getDoctrine()
            ->getRepository(Stagiaire::class)
            ->getAll();

            $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->getAll();

            $sessions = $this->getDoctrine()
            ->getRepository(Session::class)
            ->getAll();

        return $this->render('panel/index.html.twig', [
            'formations' => $formations,
            'modules' => $modules,
            'users' => $users,
            'stagiaires' => $stagiaires,
            'categories' => $categories,
            'sessions' => $sessions
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/panel/ajouter", name="panel_stagiaire_add")
     * @Route("/panel/edit{id}", name="stagiaire_edit")
     */
    public function addEdit(Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$stagiaire) {
            $stagiaire = new Stagiaire();
        }
        $form = $this->createForm(AddStagiaireType::class, $stagiaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('sessions')->getData();
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
     * @Route("/panel/ajouterStagiaire", name="panel_ajouterStagiaire")
     */
    // public function ajouterStagiaire(): Response
    // {

    //     $stagiaires = $this->getDoctrine()
    //         ->getRepository(Stagiaire::class)
    //         ->getAll();

    //     return $this->render('stagiaire/index.html.twig', [
    //         'stagiaires' => $stagiaires,
    //     ]);
    // }
}
