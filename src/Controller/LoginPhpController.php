<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuarios; 

final class LoginPhpController extends AbstractController
{
    #[Route('/login', name: 'app_login_php')]
    public function Login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager): Response
    {   
        $correo = $request->get('_username'); 
        $contraseña = $request->get('_password');
        $rep = $entityManager->getRepository(Usuarios::class);
        $ents = $rep-> findBy(['correo' => $correo, 'contraseña' => $contraseña]);
        if (empty($ents)){
            return $this->render('login.html.twig', [
                'error' => 'Correo o contraseña incorrectos',
            ]);
        }else{
            return $this->redirectToRoute('after_login');
        }

            

        // Comprueba si hubo algún error
         $error = $authenticationUtils->getLastAuthenticationError();

        // Recupera el último nombre de usuario que se probó
         $lastUsername = $authenticationUtils->getLastUsername();

        // Renderizar el formulario de login
        return $this->render('login.html.twig');
    }
}
