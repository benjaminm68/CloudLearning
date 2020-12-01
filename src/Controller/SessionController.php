<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\AddSessionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{

     /**
      * @IsGranted("ROLE_ADMIN")
      * @Route("/delete/{id}", name="session_delete")
      */
    public function delete(Session $session){

        $em = $this->getDoctrine()->getManager();

        $em->remove($session);
        $em->flush();

        return $this->redirectToRoute('session_index');
    }


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
       * @IsGranted("ROLE_ADMIN")
       * @Route("/ajouter", name="session_add")
       * @Route("/edit{id}", name="session_edit")
       */
    public function addEdit(Session $session = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$session) {
            $session = new Session();
        }
        $form = $this->createForm(AddSessionType::class, $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($session);
            $manager->flush();
            return $this->redirectToRoute('session_index');
        }
        return $this->render('session/add.html.twig', [
            'AddSessionType' => $form->createView(),
            'editMode' => $session->getId() !==null,
            'session' => $session->getNom()
        ]);
    }
}
