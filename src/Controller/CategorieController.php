<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="categorie_index")
     */
    public function index(): Response
    {
        
    $categories = $this->getDoctrine()
    ->getRepository(Categorie::class)
    ->getAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    public function show(Categorie $categorie): Response {
        return $this->render('home/index.html.twig', ['categorie' => $categorie]);
    }
}
