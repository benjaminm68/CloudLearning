<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stagiaire")
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

    public function show(Stagiaire $stagiaire): Response {
        return $this->render('home/index.html.twig', ['stagiaire' => $stagiaire]);
    }
}

