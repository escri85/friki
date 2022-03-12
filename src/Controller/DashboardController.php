<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Config\KnpPaginatorConfig;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(EntityManagerInterface $doctrine,Request $request): Response
    {
      
        $posts = $doctrine->getRepository(Posts::class)->findAll();
        
        return $this->render('dashboard/index.html.twig', [
           'posts'=>$posts
        ]);
    }
}
