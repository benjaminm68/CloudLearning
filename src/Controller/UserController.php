<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
     * @Route("user")
     */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index")
     */
    public function index(): Response
    {

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->getAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response {
        return $this->render('user/show.html.twig', [
            'user' => $user
            ]);
    }

    /**
     * @Route("/{id}", name="user_edit", methods="POST")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response {
        return $this->render('user/show.html.twig', ['user' => $user]);

        if(!$user) {
            $user = new User();
        }
        $form = $this->createForm(EditUserType::class, $user);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);// équivalent de prepare()
            $manager->flush();// pour valider les changements dans la base de données, il "sait" si il doit UPDATE ou INSERT et ce pour tout les objets persist()
            return $this->redirectToRoute('/{id}');
        }
        return $this->render('user/show.html.twig', [
            'formEditUser'=>$form->createView(),
         
        ]);
    }


}
