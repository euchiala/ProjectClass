<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Form\EditeurType;
use App\Repository\EditeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/editeur')]
class EditeurController extends AbstractController
{
    #[Route('/', name: 'app_editeur_index', methods: ['GET'])]
    public function index(EditeurRepository $editeurRepository): Response
    {
        return $this->render('editeur/index.html.twig', [
            'editeurs' => $editeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_editeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EditeurRepository $editeurRepository): Response
    {
        $editeur = new Editeur();
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editeurRepository->add($editeur, true);

            return $this->redirectToRoute('app_editeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('editeur/new.html.twig', [
            'editeur' => $editeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_editeur_show', methods: ['GET'])]
    public function show(Editeur $editeur): Response
    {
        return $this->render('editeur/show.html.twig', [
            'editeur' => $editeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_editeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Editeur $editeur, EditeurRepository $editeurRepository): Response
    {
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editeurRepository->add($editeur, true);

            return $this->redirectToRoute('app_editeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('editeur/edit.html.twig', [
            'editeur' => $editeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_editeur_delete', methods: ['POST'])]
    public function delete(Request $request, Editeur $editeur, EditeurRepository $editeurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editeur->getId(), $request->request->get('_token'))) {
            $editeurRepository->remove($editeur, true);
        }

        return $this->redirectToRoute('app_editeur_index', [], Response::HTTP_SEE_OTHER);
    }
}
