<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\SupportFormType;
use App\Repository\SupportRepository;
use App\Repository\SupportTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/support")
 * @Security("is_granted('ROLE_USER')")
 */
class SupportController extends AbstractController
{
    /**
     * @Route("/", name="support_index", methods={"GET"})
     */
    public function index(SupportRepository $supportRepository, SupportTypeRepository $supportTypeRepository): Response
    {
        $supports = $supportRepository->findAll();
        foreach ($supports as $support) {
            $supportType = $supportTypeRepository->findOneBy(['id' => $support->getIdsupporttype()]);
            $support->setSupportType($supportType);
        }
        return $this->render('support/index.html.twig', [
            'supports' => $supports,
        ]);
    }

    /**
     * @Route("/new", name="support_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $support = new Support();
        $form = $this->createForm(SupportFormType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $support
                ->setCreatedat(new \DateTime('now'))
                ->setUpdatedat(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $supportType = $support->getSupportType();
            $support->setIdsupporttype($supportType->getId());
            dd($support);
            $entityManager->persist($support);
            $entityManager->flush();

            return $this->redirectToRoute('support_index');
        }

        return $this->render('support/new.html.twig', [
            'support' => $support,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="support_show", methods={"GET"})
     */
    public function show(Support $support, SupportTypeRepository $supportTypeRepository): Response
    {
        $supportType = $supportTypeRepository->findOneBy(['id' => $support->getIdsupporttype()]);
        $support->setSupportType($supportType);
        return $this->render('support/show.html.twig', [
            'support' => $support,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="support_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Support $support): Response
    {
        $form = $this->createForm(SupportFormType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supportType = $support->getSupportType();
            $support->setIdsupporttype($supportType->getId());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('support_index');
        }

        return $this->render('support/edit.html.twig', [
            'support' => $support,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="support_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Support $support): Response
    {
        if ($this->isCsrfTokenValid('delete' . $support->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($support);
            $entityManager->flush();
        }

        return $this->redirectToRoute('support_index');
    }
}
