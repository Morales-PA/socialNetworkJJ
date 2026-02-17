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
use App\Entity\Posts;


final class dashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'mainDashboard')] // TODO: Make the user search function return a mmesage when zero users are found and not show the user already logged in
    public function method1(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        $userToSearch = $request->request->get("_userToSearch");

        // $user = $this->getNombre(); Ask dani about the predefine methods to interact with the logged user

        if (!empty($userToSearch)) {
        
            $usersFoundArray = $em->createQuery("SELECT u FROM App\Entity\Usuarios u WHERE u.nombre LIKE '%$userToSearch%' AND ")->getResult();
        
        } else {

            $usersFoundArray = null;
        }
            
        return $this->render('dashboardTemplates/mainDashboard.html.twig', [ "usersFoundArray" => $usersFoundArray ] );
    }

    #[Route('/personalProfileDashboard', name: 'personalProfileDashboard')]
    public function method2(AuthenticationUtils $authenticationUtils , Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        $loggedUser= $request->query->get("loggedUser");

        $foundUserPostsArray = $em->createQuery("SELECT p FROM App\Entity\Posts p WHERE p.usuario = '$loggedUser'")->getResult();

        return $this->render('dashboardTemplates/personalProfileDashboard.html.twig', [ "userPostsArray" => $foundUserPostsArray ]);
    }

    #[Route('/createPostDashboard', name: 'createPostDashboard')]
    public function method3(AuthenticationUtils $authenticationUtils)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        return $this->render('dashboardTemplates/createPostDashboard.html.twig');
    }
    
}