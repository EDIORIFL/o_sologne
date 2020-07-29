<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\Prospect;
use App\Form\ProspectType;
use App\Form\SearchType;
use App\Repository\ActivityAreaRepository;
use App\Repository\CommandRepository;
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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/prospect")
 * @Security("is_granted('ROLE_USER')")
 */
class ProspectController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
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
        $datas = [];
        $form->handleRequest($request);
        $filters = $this->session->get('last-search');
        $page = $request->query->getInt('page');
        $lastPage = $this->session->get('last-page');
        if ($page > 1) {
            $lastPage = $page;
            $this->session->set('last-page', $lastPage);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            // $lastPage = 1;
            $filters = $form->getData();
            $this->session->set('last-search', $filters);
            $datas = $prospectRepository->findBySearchForm($filters);
        } 
        elseif ($filters !== null) {
            $datas = $prospectRepository->findBySearchForm($filters);
        }
        else {
            $datas = $prospectRepository->findAll();
        }
        foreach ($datas as $prospect) {
            $activityArea = $activityAreaRepository->findOneBy(['id' => $prospect->getIdactivityarea()]);
            $prospectStatus = $prospectStatusRepository->findOneBy(['id' => $prospect->getIdprospectstatus()]);
            $prospect
                ->setActivityArea($activityArea ? $activityArea : null)
                ->setProspectStatus($prospectStatus);
        }

        if (!isset($filters['display'])) {
            $filters['display'] = 20;
        }
        if ($page === null && $lastPage === null) {
            $page = 1;
            $lastPage = 1;
        }
        $prospects = $paginator->paginate($datas,$page ? $page : $lastPage, $filters['display']);
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
        PublicityRepository $publicityRepository,
        CommandRepository $commandRepository
    ): Response {
        $user = $userRepository->findOneBy(['id' => $prospect->getIdaccount()]);
        $activityArea = $activityAreaRepository->findOneBy(['id' => $prospect->getIdactivityarea()]);
        $prospectStatus = $prospectStatusRepository->findOneBy(['id' => $prospect->getIdprospectstatus()]);
        $commands = $commandRepository->findBy(['idprospect' => $prospect->getId()]);
        $publicities = $publicityRepository->findBy(['idprospect' => $prospect->getId()]);
        $prospect
            ->setUser($user ? $user : null)
            ->setActivityArea($activityArea ? $activityArea : null)
            ->setProspectStatus($prospectStatus);
        return $this->render('prospect/show.html.twig', [
            'prospect' => $prospect,
            'commands' => $commands,
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
