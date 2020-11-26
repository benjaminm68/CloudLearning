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
     * @Route("/myaccount", name="user_myaccount")
     */
    public function  myAccount(Request $request, EntityManagerInterface $manager)
    {

        $user = $this->getUser();
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user); // équivalent de prepare()
            $manager->flush(); // pour valider les changements dans la base de données, il "sait" si il doit UPDATE ou INSERT et ce pour tout les objets persist()
            return $this->redirectToRoute('user_myaccount');
        }
    
        return $this->render('user/myaccount.html.twig', [
            'EditUserType' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    // /**
    //  * @Route("/editEmail", name="user_editEmail")
    //  */
    // public function editEmail(Request $request, EntityManagerInterface $manager): Response
    // {
    //      $user = $this->getUser();
    //     $form = $this->createForm(EditUserType::class, $user);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $manager->persist($user); // équivalent de prepare()
    //         $manager->flush(); // pour valider les changements dans la base de données, il "sait" si il doit UPDATE ou INSERT et ce pour tout les objets persist()
    //         return $this->redirectToRoute('user_myaccount');
    //     }
    //     $user = new User();
    //     return $this->render('user/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }



    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }



}
