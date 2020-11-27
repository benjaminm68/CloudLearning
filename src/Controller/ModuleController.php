<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\AddModuleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

          /**
 * @Route("/add", name="module_add")
 */
 
 public function addModule(Module $module = null, Request $request, EntityManagerInterface $manager)
 {
    if(!$module) {
        $module = new Module();
    }

    $form = $this->createForm(AddModuleType::class, $module);
    $form -> handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $manager->persist($module);
        $manager->flush();

        return $this->redirectToRoute('module_index');
    }

    return $this->render('module/add.html.twig', [
        'AddModuleType'=>$form->createView(),
    ]);

 }
    
}
