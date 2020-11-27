<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/{id}", name="stagiaire_show", methods="GET")
     */
    public function show(Stagiaire $stagiaire): Response {
        return $this->render('stagiaire/show.html.twig', ['stagiaire' => $stagiaire]);
    }
}

