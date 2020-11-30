<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\AddCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/delete/{id}", name="categorie_delete")
     */
    public function delete(Categorie $categorie)
    {

        $em = $this->getDoctrine()->getManager();

        $em->remove($categorie);
        $em->flush();

        return $this->redirectToRoute('categorie_index');
    }


    /**
     * @Route("/", name="categorie_index")
     */
    public function index(): Response
    {

        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->getAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }


    /**
     * @Route("/ajouter", name="categorie_add")
     * @Route("/edit{id}", name="categorie_edit")
     */
    public function addEdit(Categorie $categorie = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$categorie) {
            $categorie = new Categorie();
        }
        $form = $this->createForm(AddCategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute('categorie_index');
        }
        return $this->render('categorie/add.html.twig', [
            'AddCategorieType' => $form->createView(),
            'editMode' => $categorie->getId() !== null,
            'categorie' => $categorie->getNom()
        ]);
    }
}
