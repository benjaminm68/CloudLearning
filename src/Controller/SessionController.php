<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\AddSessionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/ajouter", name="session_add")
     */
    public function add(Session $session = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$session) {
            $session = new Session();
        }
        $form = $this->createForm(AddSessionType::class, $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($session); // équivalent de prepare()
            $manager->flush(); // pour valider les changements dans la base de données, il "sait" si il doit UPDATE ou INSERT et ce pour tout les objets persist()
            return $this->redirectToRoute('session');
        }
        return $this->render('session/add.html.twig', [
            'AddSessionType' => $form->createView()
        ]);
    }
}
