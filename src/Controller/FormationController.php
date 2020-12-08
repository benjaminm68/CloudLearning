<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Contact;
use App\Entity\Formation;
use App\Form\ContactType;
use App\Form\ModulesType;
use App\Form\AddFormationType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("formation")
 */
class FormationController extends AbstractController
{

     /**
      * @IsGranted("ROLE_ADMIN")
      * @Route("/addDuree/{id}", name="add_duree")
      */
      public function addModuleToFormation(Formation $formation, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(ModulesType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($formation);
            $manager->flush();
            return $this->redirectToRoute('formation_index');
        }

        return $this->render('duree/addDuree.html.twig', [
            'form' => $form->createView(),
            'formation' => $formation,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/delete/{id}", name="formation_delete")
     */
    public function delete(Formation $formation){

        $em = $this->getDoctrine()->getManager();

        $em->remove($formation);
        $em->flush();

        return $this->redirectToRoute('formation_index');

    }


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
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ajouter", name="formation_add")
     * @Route("/edit{id}", name="formation_edit")
     */
    public function addEdit(Formation $formation = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$formation) {
            $formation = new Formation();
        }
        $form = $this->createForm(AddFormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($formation);
            $manager->flush();
            return $this->redirectToRoute('formation_index');
        }
        return $this->render('panel/panel-ajouterStagiaire.html.twig', [
            'AddFormationType' => $form->createView(),
            'editMode' => $formation->getId() !==null,
            'formation' => $formation->getNom()
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
                        'Nom : ' .  $contactFormData['lastname'] . \PHP_EOL .
                        'Prénom : ' .  $contactFormData['firstname'] . \PHP_EOL .
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
    
    /**
     * @Route("/pdf/{id}", name="pdf_formation", methods="GET")
     */
    public function pdfFormation(Formation $formation, Request $request, EntityManagerInterface $manager)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/pdfDetailFormation.html.twig', [
            'formation'=> $formation
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
}
