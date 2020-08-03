<?php

namespace App\Controller;

use App\Entity\Command;
use App\Form\CommandType;
use App\Repository\CommandRepository;
use App\Repository\ProspectRepository;
use App\Repository\SupportRepository;
use App\Repository\SupportTypeRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/command")
 * @Security("is_granted('ROLE_USER')")
 */
class CommandController extends AbstractController
{
    /**
     * @Route("/", name="command_index", methods={"GET"})
     */
    public function index(
        Request $request,
        CommandRepository $commandRepository,
        ProspectRepository $prospectRepository,
        SupportRepository $supportRepository,
        SupportTypeRepository $supportTypeRepository,
        PaginatorInterface $paginator
    ): Response {
        $datas = $commandRepository->findAll();

        foreach ($datas as $command) {
            $prospect = $prospectRepository->findOneBy(['id' => $command->getIdprospect()]);
            $support = $supportRepository->findOneBy(['id' => $command->getIdsupport()]);
            if ($support) {
                $supportType = $supportTypeRepository->findOneBy(['id' => $support->getIdsupporttype()]);
                $command->setSupport($support);
                $support->setSupportType($supportType);
            }
            if ($prospect) {
                $command->setProspect($prospect);
            }
        }
        $commands = $paginator->paginate($datas, $request->query->getInt('page', 1), 20);
        return $this->render('command/index.html.twig', [
            'commands' => $commands,
        ]);
    }

    /**
     * @Route("/new", name="command_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $command = new Command();
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $prospect = $command->getProspect();
            $support = $command->getSupport();
            $command
                ->setIdprospect($prospect)
                ->setIdsupport($support)
                ->setCreatedat(new DateTime('now'))
                ->setUpdatedat(new DateTime('now'));
            $entityManager->persist($command);
            $entityManager->flush();

            return $this->redirectToRoute('command_index');
        }

        return $this->render('command/new.html.twig', [
            'command' => $command,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="command_show", methods={"GET"})
     */
    public function show(
        Command $command,
        ProspectRepository $prospectRepository,
        SupportRepository $supportRepository,
        SupportTypeRepository $supportTypeRepository
    ): Response {
        $prospect = $prospectRepository->findOneBy(['id' => $command->getIdprospect()]);
        $support = $supportRepository->findOneBy(['id' => $command->getIdsupport()]);
        if ($support) {
            $supportType = $supportTypeRepository->findOneBy(['id' => $support->getIdsupporttype()]);
            $command->setSupport($support);
            $support->setSupportType($supportType);
        }
        if ($prospect) {
            $command->setProspect($prospect);
        }
        return $this->render('command/show.html.twig', [
            'command' => $command,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="command_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Command $command): Response
    {
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prospect = $command->getProspect();
            $support = $command->getSupport();
            $command
                ->setIdprospect($prospect)
                ->setIdsupport($support)
                ->setUpdatedat(new DateTime('now'));
            $this->getDoctrine()->getManager()->flush();
            // \dd($command);

            return $this->redirectToRoute('command_index');
        }

        return $this->render('command/edit.html.twig', [
            'command' => $command,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="command_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Command $command): Response
    {
        if ($this->isCsrfTokenValid('delete' . $command->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($command);
            $entityManager->flush();
        }

        return $this->redirectToRoute('command_index');
    }
}
