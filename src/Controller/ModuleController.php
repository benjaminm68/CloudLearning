<?php

namespace App\Controller;

use App\Entity\Module;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->getAll();

        return $this->render('module/index.html.twig', [
            'modules' => $modules,
        ]);
    }
}
