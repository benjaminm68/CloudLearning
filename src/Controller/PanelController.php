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
    
  

   

    
}
