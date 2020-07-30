<?php

namespace App\Controller;

use App\Repository\ProspectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavbarController extends AbstractController
{

    public function renderNavbar(ProspectRepository $prospectRepository)
    {
        $countProspect = $prospectRepository->countAllProspects();

        return $this->render('_navbar.html.twig', [
            'count' => $countProspect
        ]);
    }

}