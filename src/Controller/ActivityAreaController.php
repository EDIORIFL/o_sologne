<?php

namespace App\Controller;

use App\Entity\ActivityArea;
use App\Form\ActivityAreaType;
use App\Repository\ActivityAreaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/activity/area")
 * @Security("is_granted('ROLE_USER')")
 */
class ActivityAreaController extends AbstractController
{
    /**
     * @Route("/", name="activity_area_index", methods={"GET"})
     */
    public function index(ActivityAreaRepository $activityAreaRepository): Response
    {
        return $this->render('activity_area/index.html.twig', [
            'activity_areas' => $activityAreaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="activity_area_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $activityArea = new ActivityArea();
        $form = $this->createForm(ActivityAreaType::class, $activityArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activityArea);
            $entityManager->flush();

            return $this->redirectToRoute('activity_area_index');
        }

        return $this->render('activity_area/new.html.twig', [
            'activity_area' => $activityArea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activity_area_show", methods={"GET"})
     */
    public function show(ActivityArea $activityArea): Response
    {
        return $this->render('activity_area/show.html.twig', [
            'activity_area' => $activityArea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activity_area_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ActivityArea $activityArea): Response
    {
        $form = $this->createForm(ActivityAreaType::class, $activityArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activity_area_index');
        }

        return $this->render('activity_area/edit.html.twig', [
            'activity_area' => $activityArea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activity_area_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ActivityArea $activityArea): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activityArea->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activityArea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activity_area_index');
    }
}
