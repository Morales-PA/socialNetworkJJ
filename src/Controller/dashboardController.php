<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Dom\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Usuarios;

final class dashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'mainDashboard')]
    public function method1(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $em)
    {
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        $userToSearch = $request->request->get("_userToSearch");

        if (!empty($userToSearch)) {

            $foundUsersArray = $em->createQuery("'SELECT u FROM App\Entity\Usuarios u WHERE u.nombre = User1'");
        
            return new Response(var_dump($foundUsersArray));    
        }

        return $this->render('dashboardTemplates/mainDashboard.html.twig');
    }

    #[Route('/profileDashboard', name: 'profileDashboard')]
    public function method2()
    {
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        return $this->render('dashboardTemplates/profileDashboard.html.twig');
    }

    #[Route('/createPostDashboard', name: 'createPostDashboard')]
    public function method3()
    {

        return $this->render('dashboardTemplates/createPostDashboard.html.twig');
    }
    
}