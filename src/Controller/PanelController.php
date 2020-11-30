<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Normalement on écrit adminController <----


class PanelController extends AbstractController
{

    /**
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @Route("/panel", name="panel_accueil")
     */
    public function index(): Response
    {
        return $this->render('panel/index.html.twig', [
            'controller_name' => 'PanelController',
        ]);
    }
}
