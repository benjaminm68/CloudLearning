<?php

namespace App\Controller;


use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->getAll();


        return $this->render('home/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
