<?php

namespace App\Controller;

use App\Entity\Prospect;
use App\Form\ProspectType;
use App\Form\SearchType;
use App\Repository\ActivityAreaRepository;
use App\Repository\ProspectRepository;
use App\Repository\ProspectStatusRepository;
use App\Repository\PublicityRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/prospect")
 * @Security("is_granted('ROLE_USER')")
 */
class ProspectController extends AbstractController
{
    /**
     * @Route("/", name="prospect_index")
     */
    public function index(
        Request $request,
        ProspectRepository $prospectRepository,
        ActivityAreaRepository $activityAreaRepository,
        ProspectStatusRepository $prospectStatusRepository,
        PaginatorInterface $paginator
    ): Response {
        $form = $this->createForm(SearchType::class);
        $datas = $prospectRepository->findAll();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
            $datas = $prospectRepository->findBySearchForm($datas);
        }
        foreach ($datas as $prospect) {
            $activityArea = $activityAreaRepository->findOneBy(['id' => $prospect->getIdactivityarea()]);
            $prospectStatus = $prospectStatusRepository->findOneBy(['id' => $prospect->getIdprospectstatus()]);
            $prospect
                ->setActivityArea($activityArea ? $activityArea : null)
                ->setProspectStatus($prospectStatus);
        }
        $prospects = $paginator->paginate($datas, $request->query->getInt('page', 1), 20);
        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospects,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="prospect_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $prospect = new Prospect();
        $form = $this->createForm(ProspectType::class, $prospect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $prospect->getUser();
            $activityArea = $prospect->getActivityArea();
            $prospectStatus = $prospect->getProspectStatus();
            $prospect
                ->setIdaccount($user->getId())
                ->setIdactivityarea($activityArea->getId())
                ->setIdprospectstatus($prospectStatus->getId());
            $prospect
                ->setCreatedat(new DateTime('now'))
                ->setUpdatedat(new DateTime('now'));
            $entityManager->persist($prospect);
            $entityManager->flush();

            return $this->redirectToRoute('prospect_index');
        }

        return $this->render('prospect/new.html.twig', [
            'prospect' => $prospect,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="prospect_show", methods={"GET"})
     */
    public function show(
        Prospect $prospect,
        UserRepository $userRepository,
        ActivityAreaRepository $activityAreaRepository,
        ProspectStatusRepository $prospectStatusRepository,
        PublicityRepository $publicityRepository
    ): Response {
        $user = $userRepository->findOneBy(['id' => $prospect->getIdaccount()]);
        $activityArea = $activityAreaRepository->findOneBy(['id' => $prospect->getIdactivityarea()]);
        $prospectStatus = $prospectStatusRepository->findOneBy(['id' => $prospect->getIdprospectstatus()]);
        $publicities = $publicityRepository->findBy(['idprospect' => $prospect->getId()]);
        $prospect
            ->setUser($user ? $user : null)
            ->setActivityArea($activityArea ? $activityArea : null)
            ->setProspectStatus($prospectStatus);
        return $this->render('prospect/show.html.twig', [
            'prospect' => $prospect,
            'publicities' => $publicities
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prospect_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Prospect $prospect): Response
    {
        $form = $this->createForm(ProspectType::class, $prospect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $prospect->getUser();
            $activityArea = $prospect->getActivityArea();
            $prospectStatus = $prospect->getProspectStatus();
            $prospect
                ->setIdaccount($user->getId())
                ->setIdactivityarea($activityArea->getId())
                ->setIdprospectstatus($prospectStatus->getId());
            $prospect->setUpdatedat(new DateTime('now'));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prospect_index');
        }

        return $this->render('prospect/edit.html.twig', [
            'prospect' => $prospect,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prospect_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Prospect $prospect): Response
    {
        if ($this->isCsrfTokenValid('delete' . $prospect->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prospect);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prospect_index');
    }
}
