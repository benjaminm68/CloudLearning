<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\AddModuleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
     * @Route("module")
     */
class ModuleController extends AbstractController
{

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/delete/{id}", name="module_delete")
     */
    public function delete(Module $module){

        $em = $this->getDoctrine()->getManager();

        $em->remove($module);
        $em->flush();

        return $this->redirectToRoute('module_index');
    }


    /**
     * @Route("/", name="module_index")
     */
    public function index(): Response
    {
        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->getAll();

        return $this->render('panel/panel-listeModule.html.twig', [
            'modules' => $modules,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ajouter", name="module_add")
     * @Route("/edit{id}", name="module_edit")
     */
    public function addEdit(Module $module = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$module) {
            $module = new Module();
        }
        $form = $this->createForm(AddModuleType::class, $module);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($module);
            $manager->flush();
            return $this->redirectToRoute('module_index');
        }
        return $this->render('panel/panel-ajouterModule.html.twig', [
            'AddModuleType' => $form->createView(),
            'editMode' => $module->getId() !==null,
            'module' => $module->getNom()
        ]);
    }

 }
    
 

