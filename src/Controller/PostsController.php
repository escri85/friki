<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
class PostsController extends AbstractController
{
    #[Route('/Registrar-Posts', name: 'RegistrarPosts')]
    public function index(Request $request, EntityManagerInterface $doctrine , SluggerInterface $slugger ): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class,$post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $File = $form['foto']->getData();
            if ($File) {
                $originalFilename = pathinfo($File->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$File->guessExtension();
                try {
                    $File->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                   throw new \Exception('UPs! ha ocurrido un error, sorry :c');
                }
                $post->setFoto($newFilename);
            }
            $user = $this->getUser();
            $post->setUser($user);
            $doctrine->persist($post);
            $doctrine->flush();
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('posts/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    
    
}
