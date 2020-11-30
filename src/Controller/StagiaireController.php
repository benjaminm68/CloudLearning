<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\AddStagiaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/secretariat")
 */

class StagiaireController extends AbstractController
{
    /**
     * @Route("/", name="stagiaire_index")
     */
    public function index(): Response
    {
        
    $stagiaires = $this->getDoctrine()
    ->getRepository(Stagiaire::class)
    ->getAll();

        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    /**
    * @Route("/ajouter", name="stagiaire_add")
    */

   public function add(Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $manager)
   {
       if (!$stagiaire) {
           $stagiaire = new Stagiaire();
       }
       $form = $this->createForm(AddStagiaireType::class, $stagiaire);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $manager->persist($stagiaire); // équivalent de prepare()
           $manager->flush(); // pour valider les changements dans la base de données, il "sait" si il doit UPDATE ou INSERT et ce pour tout les objets persist()
           return $this->redirectToRoute('stagiaire_index');
       }
       return $this->render('stagiaire/add.html.twig', [
           'AddStagiaireType' => $form->createView()
       ]);
   }
    
     /**
     * @Route("/{id}", name="stagiaire_show", methods="GET")
     */
    public function show(Stagiaire $stagiaire): Response {
        return $this->render('stagiaire/show.html.twig', ['stagiaire' => $stagiaire]);
    }

}

