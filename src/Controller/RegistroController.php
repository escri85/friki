<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
    #[Route('/registro', name: 'registro')]
    public function index(Request $request, EntityManagerInterface $doctrine , UserPasswordHasherInterface $hasher)
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

          $user= $form->getData();
            $user->setPassword($hasher->hashPassword($user,$form['password']->getData()));
            $doctrine->persist($user);
            $doctrine->flush();
            $this->addFlash('exito','Se ha registrado exitosamente');
            return $this->redirectToRoute('registro');
        }
        return $this->render('registro/index.html.twig', [
            'controller_name' => 'HOla mundo',
            'formulario'=>$form->createView()
        ]);
    }
}


