<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("module")
     */
class ModuleController extends AbstractController
{
    /**
     * @Route("/", name="module_index")
     */
    public function index(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }
}
