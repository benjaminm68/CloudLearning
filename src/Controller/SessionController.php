<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="session_index")
     */
    public function index(): Response
    {
        
    $sessions = $this->getDoctrine()
    ->getRepository(Session::class)
    ->getAll();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    public function show(Session $session): Response {
        return $this->render('home/index.html.twig', ['session' => $session]);
    }
}
