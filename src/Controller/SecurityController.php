<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditPasswordType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/editPassword", name="user_edit_password")
     */
    public function editPassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder)
    {


        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $actualPassword = $form->get('actualPassword')->getData();

            if ($passwordEncoder->isPasswordValid($user, $actualPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                );

                $user->setPassword($newEncodedPassword);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Mot de passe modifié avec succès");

                return $this->redirectToRoute('user_myaccount');
            }
            else {
                $this->addFlash(
                    'failed',
                    "Mot de passe invalide !"
                );
            }
        }

        return $this->render('user/editPassword.html.twig', [
            'EditPasswordType' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }
}
