<?php

namespace App\Controller\Admin;

use App\Entity\Missions;
use App\Repository\MissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;

class AdminController extends AbstractController
{

    #[Route('/admin', name: 'admin')]
    public function home(): Response
    {
        return $this->render('admin/index.html.twig', [
            
        ]);
    }
}
