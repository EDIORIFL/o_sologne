<?php

namespace App\Controller;

use App\Entity\Publicity;
use App\Form\PublicityType;
use App\Repository\PublicityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publicity")
 */
class PublicityController extends AbstractController
{
    /**
     * @Route("/", name="publicity_index", methods={"GET"})
     */
    public function index(PublicityRepository $publicityRepository): Response
    {
        return $this->render('publicity/index.html.twig', [
            'publicities' => $publicityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="publicity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $publicity = new Publicity();
        $form = $this->createForm(PublicityType::class, $publicity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicity);
            $entityManager->flush();

            return $this->redirectToRoute('publicity_index');
        }

        return $this->render('publicity/new.html.twig', [
            'publicity' => $publicity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publicity_show", methods={"GET"})
     */
    public function show(Publicity $publicity): Response
    {
        return $this->render('publicity/show.html.twig', [
            'publicity' => $publicity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="publicity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publicity $publicity): Response
    {
        $form = $this->createForm(PublicityType::class, $publicity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publicity_index');
        }

        return $this->render('publicity/edit.html.twig', [
            'publicity' => $publicity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publicity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Publicity $publicity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publicity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publicity_index');
    }
}
