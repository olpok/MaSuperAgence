<?php

namespace App\Controller\Admin;

use App\Entity\Preference;
use App\Form\PreferenceType;
use App\Repository\PreferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/preference")
 */
class AdminPreferenceController extends AbstractController
{
    /**
     * @Route("/", name="admin_preference_index", methods={"GET"})
     */
    public function index(PreferenceRepository $preferenceRepository): Response
    {
        return $this->render('admin/preference/index.html.twig', [
            'preferences' => $preferenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_preference_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $preference = new Preference();
        $form = $this->createForm(PreferenceType::class, $preference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($preference);
            $entityManager->flush();

            return $this->redirectToRoute('admin_preference_index');
        }

        return $this->render('admin/preference/new.html.twig', [
            'preference' => $preference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="preference_show", methods={"GET"})
     *//*
    public function show(Preference $preference): Response
    {
        return $this->render('admin/preference/show.html.twig', [
            'preference' => $preference,
        ]);
    }*/

    /**
     * @Route("/{id}/edit", name="admin_preference_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Preference $preference): Response
    {
        $form = $this->createForm(PreferenceType::class, $preference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_preference_index');
        }

        return $this->render('admin/preference/edit.html.twig', [
            'preference' => $preference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_preference_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Preference $preference): Response
    {
        if ($this->isCsrfTokenValid('delete'.$preference->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($preference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_preference_index');
    }
}
