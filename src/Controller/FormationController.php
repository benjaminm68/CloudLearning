<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Formation;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="formation_index")
     */
    public function index(): Response
    {

        $formations = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->getAll();

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/{id}", name="formation_show")
     */
    public function show(Formation $formation, Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('testelan68@gmail.com')
                ->subject('Vous avez un nouveau message')
                ->text(
                    'Expéditeur : ' . $contactFormData['email'] . \PHP_EOL .
                    'Téléphone : ' .  $contactFormData['phone'] . \PHP_EOL .
                    'Nom : ' .  $contactFormData['lastname'] . \PHP_EOL.
                    'Prénom : ' .  $contactFormData['firstname'] . \PHP_EOL.
                        $contactFormData['message'],
                    'text/plain'
                );
            $mailer->send($message);
            $this->addFlash('success', 'Votre message a bien été envoyé.');
            return $this->redirectToRoute('formation_index');
        }
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            'form' => $form->createView()
        ]);
    }
}
