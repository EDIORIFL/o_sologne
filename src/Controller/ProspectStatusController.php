<?php

namespace App\Controller;

use App\Entity\ProspectStatus;
use App\Form\ProspectStatusType;
use App\Repository\ProspectStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prospect/status")
 */
class ProspectStatusController extends AbstractController
{
    /**
     * @Route("/", name="prospect_status_index", methods={"GET"})
     */
    public function index(ProspectStatusRepository $prospectStatusRepository): Response
    {
        return $this->render('prospect_status/index.html.twig', [
            'prospect_statuses' => $prospectStatusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="prospect_status_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $prospectStatus = new ProspectStatus();
        $form = $this->createForm(ProspectStatusType::class, $prospectStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prospectStatus);
            $entityManager->flush();

            return $this->redirectToRoute('prospect_status_index');
        }

        return $this->render('prospect_status/new.html.twig', [
            'prospect_status' => $prospectStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prospect_status_show", methods={"GET"})
     */
    public function show(ProspectStatus $prospectStatus): Response
    {
        return $this->render('prospect_status/show.html.twig', [
            'prospect_status' => $prospectStatus,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prospect_status_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProspectStatus $prospectStatus): Response
    {
        $form = $this->createForm(ProspectStatusType::class, $prospectStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prospect_status_index');
        }

        return $this->render('prospect_status/edit.html.twig', [
            'prospect_status' => $prospectStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prospect_status_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProspectStatus $prospectStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prospectStatus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prospectStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prospect_status_index');
    }
}
