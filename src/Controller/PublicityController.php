<?php

namespace App\Controller;

use App\Entity\Publicity;
use App\Form\PublicityType;
use App\Repository\ProspectRepository;
use App\Repository\PublicityRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/publicity")
 * @Security("is_granted('ROLE_USER')")
 */
class PublicityController extends AbstractController
{
    /**
     * @Route("/", name="publicity_index", methods={"GET"})
     */
    public function index(PublicityRepository $publicityRepository, ProspectRepository $prospectRepository): Response
    {
        $publicities = $publicityRepository->findAll();
        foreach ($publicities as $publicity) {
            $prospect = $prospectRepository->findOneBy(['id' => $publicity->getIdprospect()]);
            if ($prospect) {
                $publicity->setProspect($prospect);
            }
        }
        return $this->render('publicity/index.html.twig', [
            'publicities' => $publicities,
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
            $publicity
                ->setCreatedat(new DateTime('now'))
                ->setUpdatedat(new DateTime('now'));
            $file = $form['file']->getData();
            $extension = $file->guessExtension();
            $filename = time() . "." . $extension;
            $file->move('files/', $filename);
            $publicity->setFilename($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $prospect = $publicity->getProspect();
            $publicity->setIdprospect($prospect->getId());
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
        $file = new UploadedFile('./files/'.$publicity->getFilename(), $publicity->getFilename());
        $publicity->setFile($file);
        $form->handleRequest($request);
        $filesystem = new Filesystem;

        if ($form->isSubmitted() && $form->isValid()) {
            if ($filesystem->exists('files/'.$publicity->getFilename)) {
                $filesystem->remove('files/'.$publicity->getFilename());
            }
            $publicity
                ->setUpdatedat(new DateTime('now'));
            $file = $form['file']->getData();
            $extension = $file->guessExtension();
            $filename = time() . "." . $extension;
            $file->move('files/', $filename);
            $publicity->setFilename($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $prospect = $publicity->getProspect();
            $publicity->setIdprospect($prospect->getId());
            $entityManager->persist($publicity);
            $entityManager->flush();

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
        if ($this->isCsrfTokenValid('delete' . $publicity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publicity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publicity_index');
    }
}
