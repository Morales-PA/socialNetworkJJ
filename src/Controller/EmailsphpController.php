<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuarios; 

final class EmailsphpController extends AbstractController
{
    #[Route('/cambiarContraseña', name: 'change_password')]
    public function CambiarContraseña()
    {   
        return $this->render('changePassword.html.twig');
    }

    #[Route('/crearCuenta', name: 'create_account')]
    public function CrearCuenta()
    {   
        return $this->render('createAccount.html.twig');
    }
    
    #[Route('/ConfirmarNuevaCuenta', name: 'confirm_account')]
    public function ConfirmarCuenta(Request $request, EntityManagerInterface $entityManager)
    {   
        $correcito = $request->get('new_email');
        $contraseñita = $request->get('new_password');
        $repo = $entityManager->getRepository(Usuarios::class);
        $usuario = $repo->findOneBy(['email' => $correcito]);
        if (!$usuario) {
            // $nuevoUsuario = new Usuarios();
            // $nuevoUsuario->setEmail($correcito);
            // $nuevoUsuario->setPassword(password_hash($contraseñita, PASSWORD_BCRYPT));
            // $entityManager->persist($nuevoUsuario);
            // $entityManager->flush();
        } else {
            // Manejar el caso en que el correo ya existe
            return $this->render('createAccount.html.twig', ['error' => 'El correo ya está registrado.']);
        }
        return $this->render('confirmAccount.html.twig', ['email' => $correcito]);
    }

    #[Route('/CorreoEnviado', name: 'send_email')]
    public function EnviarCorreo()
    {   
        return $this->render('sendEmailToRecoverPassword.html.twig');
    }
}
