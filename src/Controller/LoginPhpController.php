<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuarios; 

final class LoginPhpController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function Login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager)
    {   
        {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
}


    }

    #[Route('/after_login', name: 'after_login')]
    public function afterLogin(Request $request, AuthenticationUtils $authenticationUtils)
    {   
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        return $this->render('afterLogin.html.twig');

    }

    // #[Route('/after_login', name: 'after_login')]
    // public function afterLogin(Request $request, AuthenticationUtils $authenticationUtils)
    // {   
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
    //     $user = $this->getUser(); // Usuario autenticado
            
    //     return $this->render('afterLogin.html.twig', [
    //         'nombre' => $user->getNombre(),
    //     ]);

    // }
}


