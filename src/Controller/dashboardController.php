<?php

namespace App\Controller;

use App\Entity\Comentarios;
use Doctrine\ORM\EntityManagerInterface;
use Dom\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Usuarios;
use App\Entity\Posts;
use App\Entity\Seguidores;


final class dashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'mainDashboard')] // TODO: Make the user search function return a mmesage when zero users are found and not show the user already logged in
    public function method1(Request $request, EntityManagerInterface $em)
    {
        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        if ($this->getUser()->getActivo() == 0 ) {
            return $this->redirectToRoute("logout");
        }

        $userToSearch = $request->request->get("_userToSearch");
        $curretUserName = $this->getUser()->getNombre();

        if (!empty($userToSearch)) {

            $usersFoundArray = $em->createQuery("SELECT u FROM App\Entity\Usuarios u WHERE u.nombre LIKE '%$userToSearch%' AND u.nombre NOT LIKE '%$curretUserName%'")->getResult();

        } else {

            $usersFoundArray = $em->createQuery("SELECT u FROM App\Entity\Usuarios u WHERE u.nombre NOT LIKE '%$curretUserName%'")->getResult();
        }
            
        return $this->render('dashboardTemplates/mainDashboard.html.twig', [ "usersFoundArray" => $usersFoundArray ] );
    }

    #[Route('/personalProfileDashboard', name: 'personal_ProfileDashboard')]
    public function method2(Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 
        
        $loggedUserId = $this->getUser()->getIdUsuario();
        $userId = $request->query->get("userId");
        $userName = $request->query->get("userName");
        $userMail = $request->query->get("userMail");
        $userPostsArray = $em->createQuery("SELECT p FROM App\Entity\Posts p WHERE p.usuario = '$userId'")->getResult();
        
        if ($loggedUserId == $userId) {
        
            return $this->render('dashboardTemplates/personalProfileDashboard.html.twig', [ "userName" => $userName, "userEmail" => $userMail, "userPostsArray" => $userPostsArray ]);
        }
        
        // Check if there is an accepted follow relationship
        $followingState = $em->createQuery("SELECT s FROM App\Entity\Seguidores s WHERE s.seguidor = '$loggedUserId' AND s.seguido = '$userId'")->getResult();
        
        if (empty($followingState)) {
            // No follow request exists
            return $this->render('dashboardTemplates/notFollowingProfile.html.twig', [ "userName" => $userName, "userEmail" => $userMail, "userId" => $userId, "followStatus" => 'none' ]);
        }
        
        $follow = $followingState[0];
        
        if ($follow->getEstado() == 'aceptado') {
            // Follow is accepted, show posts
            return $this->render('dashboardTemplates/personalProfileDashboard.html.twig', [ "userName" => $userName, "userEmail" => $userMail, "userPostsArray" => $userPostsArray ]);
        } else {
            // Follow is pending
            return $this->render('dashboardTemplates/notFollowingProfile.html.twig', [ "userName" => $userName, "userEmail" => $userMail, "userId" => $userId, "followStatus" => 'pending' ]);
        }
    }

    #[Route('/commentsDisplayer', name: 'comments_displayer')]
    public function method3(Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        $postId = $request->query->get("postId");

        $postCommentsArray = $em->createQuery("SELECT c FROM App\Entity\Comentarios c WHERE c.post = '$postId'")->getResult();

        return $this->render('dashboardTemplates/commentsDisplayer.html.twig', [ "postCommentsArray" => $postCommentsArray, "postId" => $postId]);
    }

    #[Route('/createPostDashboard', name: 'create_PostDashboard')]
    public function method4()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        return $this->render('dashboardTemplates/createPostDashboard.html.twig');
    }

    #[Route('/postCreation', name: 'post_creation')]
    public function method5(Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");

        $contenido = $request->request->get("contenido");

        if (!$contenido) {
            $this->addFlash('warning', 'El contenido del post no puede estar vacío.');
            return $this->redirectToRoute("create_PostDashboard"); 
        }

        $newPost = new Posts();
        $newPost->setContenido($contenido);
        $newPost->setFechaPublicacion(new \DateTime());
        $newPost->setUsuarioDesdePost($this->getUser());

        $em->persist($newPost);
        $em->flush();

        $this->addFlash('warning', 'Post creado correctamente.');

        return $this->redirectToRoute('create_PostDashboard');
    }

    #[Route('/followUser', name: 'follow_user')]
    public function method6(Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $userToFollowId =  $request->query->get('userToFollowId');
        $currentUser = $this->getUser()->getIdUsuario();
        $userToFollow = $em->find(Usuarios::class, $userToFollowId);

        if (!$userToFollow) {
            $this->addFlash('error', 'Usuario no encontrado.');
            return $this->redirectToRoute('mainDashboard');
        }

        // Check if follow request already exists
        $existingFollow = $em->createQuery("SELECT s FROM App\Entity\Seguidores s WHERE s.seguidor = '$currentUser' AND s.seguido = '$userToFollowId'")->getResult();
        
        if (!empty($existingFollow)) {
            $this->addFlash('warning', 'Ya existe una solicitud de seguimiento para este usuario.');
            return $this->redirectToRoute('mainDashboard');
        }

        $follower = new Seguidores();
        $follower->setSeguidor($this->getUser());
        $follower->setSeguido($userToFollow);
        $follower->setEstado('pendiente');

        $em->persist($follower);
        $em->flush();

        $this->addFlash('warning', 'Solicitud de seguimiento enviada.');

        return $this->redirectToRoute('mainDashboard');    
    }

    #[Route('/createComment', name: 'create_Comment')]
    public function method7(Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $commentContent =  $request->request->get('_commentContent');
        
        $postId = $request->query->get('postId');
        $post = $em->find(Posts::class, $postId);
        $commentator = $this->getUser();

        if (!$post || !$commentContent) {
            $this->addFlash('warning', 'Post o comentario no encontrado.');
            return $this->redirectToRoute('mainDashboard');
        }

        $comment = new Comentarios();
        $comment->setPost($post);
        $comment->setUsuarioDesdeComentarios($commentator);
        $comment->setFechaPublicacion(new \DateTime());
        $comment->setContenido($commentContent);

        $em->persist($comment);
        $em->flush();

        $this->addFlash('success', 'Comentario creado correctamente.');

        return $this->redirectToRoute('comments_displayer', ['postId' => $postId]);    
    }

    #[Route('/pendingFollowRequests', name: 'pending_follow_requests')]
    public function viewPendingRequests(EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $loggedUserId = $this->getUser()->getIdUsuario();
        $pendingRequests = $em->createQuery("SELECT s FROM App\Entity\Seguidores s WHERE s.seguido = '$loggedUserId' AND s.estado = 'pendiente'")->getResult();

        return $this->render('dashboardTemplates/pendingFollowRequests.html.twig', [ "pendingRequests" => $pendingRequests ]);
    }

    #[Route('/acceptFollowRequest', name: 'accept_follow')]
    public function acceptFollowRequest(Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $followerUserId = $request->query->get('followerUserId');
        $loggedUserId = $this->getUser()->getIdUsuario();

        $followRequest = $em->createQuery("SELECT s FROM App\Entity\Seguidores s WHERE s.seguidor = '$followerUserId' AND s.seguido = '$loggedUserId' AND s.estado = 'pendiente'")->getResult();

        if (empty($followRequest)) {
            $this->addFlash('warning', 'Solicitud no encontrada.');
            return $this->redirectToRoute('pending_follow_requests');
        }

        $follow = $followRequest[0];
        $follow->setEstado('aceptado');
        $em->flush();

        $this->addFlash('success', 'Solicitud de seguimiento aceptada.');
        return $this->redirectToRoute('pending_follow_requests');
    }

    #[Route('/rejectFollowRequest', name: 'reject_follow')]
    public function rejectFollowRequest(Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $followerUserId = $request->query->get('followerUserId');
        $loggedUserId = $this->getUser()->getIdUsuario();

        $followRequest = $em->createQuery("SELECT s FROM App\Entity\Seguidores s WHERE s.seguidor = '$followerUserId' AND s.seguido = '$loggedUserId' AND s.estado = 'pendiente'")->getResult();

        if (empty($followRequest)) {
            $this->addFlash('error', 'Solicitud no encontrada.');
            return $this->redirectToRoute('pending_follow_requests');
        }

        $follow = $followRequest[0];
        $em->remove($follow);
        $em->flush();

        $this->addFlash('warning', 'Solicitud de seguimiento rechazada.');
        return $this->redirectToRoute('pending_follow_requests');
    }

}