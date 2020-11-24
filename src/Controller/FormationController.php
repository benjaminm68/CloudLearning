<?php

namespace App\Controller;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    public function show(Formation $formation): Response {
        return $this->render('home/index.html.twig', ['formation' => $formation]);
    }
}
