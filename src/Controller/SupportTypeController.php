<?php

namespace App\Controller;

use App\Entity\SupportType;
use App\Form\SupportTypeType;
use App\Repository\SupportTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/support/type")
 * @Security("is_granted('ROLE_USER')")
 */
class SupportTypeController extends AbstractController
{
    /**
     * @Route("/", name="support_type_index", methods={"GET"})
     */
    public function index(SupportTypeRepository $supportTypeRepository): Response
    {
        return $this->render('support_type/index.html.twig', [
            'support_types' => $supportTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="support_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $supportType = new SupportType();
        $form = $this->createForm(SupportTypeType::class, $supportType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supportType
                ->setCreatedat(new \DateTime('now'))
                ->setUpdatedat(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supportType);
            $entityManager->flush();

            return $this->redirectToRoute('support_type_index');
        }

        return $this->render('support_type/new.html.twig', [
            'support_type' => $supportType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="support_type_show", methods={"GET"})
     */
    public function show(SupportType $supportType): Response
    {
        return $this->render('support_type/show.html.twig', [
            'support_type' => $supportType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="support_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SupportType $supportType): Response
    {
        $form = $this->createForm(SupportTypeType::class, $supportType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supportType->setUpdatedat(new \DateTime('now'));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('support_type_index');
        }

        return $this->render('support_type/edit.html.twig', [
            'support_type' => $supportType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="support_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SupportType $supportType): Response
    {
        if ($this->isCsrfTokenValid('delete' . $supportType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($supportType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('support_type_index');
    }
}
