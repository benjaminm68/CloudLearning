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
     */

    public function add(Categorie $categorie = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$categorie) {
            $categorie = new Categorie();
        }
        $form = $this->createForm(AddCategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie); // équivalent de prepare()
            $manager->flush(); // pour valider les changements dans la base de données, il "sait" si il doit UPDATE ou INSERT et ce pour tout les objets persist()
            return $this->redirectToRoute('categorie_index');
        }
        return $this->render('categorie/add.html.twig', [
            'AddCategorieType' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_edit")
     */

    public function edit(Categorie $categorie, Request $request, EntityManagerInterface $manager)
    {
        if (!$categorie) {
            $categorie = new Categorie();
        }

        $form = $this->createForm(AddCategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie); // équivalent de prepare()
            $manager->flush(); // pour valider les changements dans la base de données, il "sait" si il doit UPDATE ou INSERT et ce pour tout les objets persist()

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/edit.html.twig', [
            'AddCategorieType' => $form->createView(),
            'editMode' => $categorie->getId() !== null,
        ]);
    }

    public function show(Categorie $categorie): Response
    {
        return $this->render('home/index.html.twig', ['categorie' => $categorie]);
    }
}
