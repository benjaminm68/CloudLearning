<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formation;
use App\Form\AddSessionType;
use App\Form\StagiaireType;
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

        return $this->render('panel/panel-listeSession.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    public function show(Session $session): Response {
        return $this->render('home/index.html.twig', ['session' => $session]);
    }
    

    /**
     * @Route("/calendar", name="session_calendar")
     */
    public function calendar(): Response
    {
        return $this->render('session/calendar.html.twig');
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
        $form2 = $this->createForm(StagiaireType::class, $session);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute('session_index');
        }
        
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            $manager->persist($session);
            $manager->flush();
            
            return $this->redirectToRoute('session_index');

        }

        return $this->render('panel/panel-ajouterSession.html.twig', [
            'AddSessionType' => $form->createView(),
            'editMode' => $session->getId() !==null,
            'session' => $session->getNom(),
            'AddStagiaireType' =>$form2->createView()
        ]);
    }
}
