<?php

namespace App\Controller;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuarios; 
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


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
    public function ConfirmarCuenta(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer)
    {   
        $correcito = $request->request->get('new_email');
        $contraseñita = $request->request->get('new_password');
        $nombrecito = $request->request->get('new_name');
        $repo = $entityManager->getRepository(Usuarios::class);
        
        $usuario = $repo->findOneBy(['correo' => $correcito]);
        if (!$usuario) {
            $nuevoUsuario = new Usuarios();
            $nuevoUsuario->setCorreo($correcito);
            $nuevoUsuario->setNombre($nombrecito);
            $hashedpassword = $passwordHasher->hashPassword($nuevoUsuario, $contraseñita);
            $nuevoUsuario->setContraseña($hashedpassword);
            $nuevoUsuario->setActivo(false);
            $nuevoUsuario->setAdmin(false);
            $nuevoUsuario->setFechaRegistro(new \DateTime());
            $token = bin2hex(random_bytes(32));
            $nuevoUsuario->setToken($token);
            $entityManager->persist($nuevoUsuario);
            $entityManager->flush();

            $email = (new Email())
            ->from('no-reply@JJnetwork.com')
            ->to($correcito)
            ->subject('Confirma tu cuenta')
            ->html("
            <h1>Confirma tu cuenta</h1>
            <p>Haz click en el siguiente enlace:</p>
            <a href='http://localhost:8000/confirmarCuenta/$token'>Confirmar cuenta</a>");

            $mailer->send($email);

        } else {
            //Si el correo ya existe, muestro un error en crearCuenta
            return $this->render('createAccount.html.twig', ['error' => 'El correo ya está registrado.']);
        }
        return $this->render('confirmAccount.html.twig', ['email' => $correcito]);
    }

    #[Route('/CorreoEnviado', name: 'send_email')]
    public function EnviarCorreo(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {   
        $correcito = $request->get('new_email');
        $repo = $entityManager->getRepository(Usuarios::class);
        $usuario = $repo->findOneBy(['correo' => $correcito]);
       
        if ($usuario) {
            $token = bin2hex(random_bytes(32));
            $usuario->setToken($token);
            $entityManager->flush();
            $email = (new Email())
            ->from('no-reply@JJnetwork.com')
            ->to($correcito)
            ->subject('Confirma tu cuenta')
            ->html("
            <h1>Cambia tu contraseña</h1>
            <p>Haz click en el siguiente enlace:</p>
            <a href='http://localhost:8000/cambiarContraseña/$token'>Cambiar Contraseña</a>");

            $mailer->send($email);
            return $this->render('sendEmailToRecoverPassword.html.twig', ["email" => $correcito]);
        }else{
            $error = 1;
            return $this->render('changePassword.html.twig', ["error" => $error]);
        }
    }

    #[Route('/confirmarCuenta/{token?}', name: 'confirmr_account_with_email')]
    public function ConfirmarCuentaPorCorreo($token, EntityManagerInterface $entityManager)
    {
        if (!$token) {
            return $this->render('cuentaCreada.html.twig', [
                'mensaje' => 'Falta el token en la URL'
            ]);
        }

        $repo = $entityManager->getRepository(Usuarios::class);
        $usuario = $repo->findOneBy(['token' => $token]);

        if (!$usuario) {
            return $this->render('cuentaCreada.html.twig', [
                'mensaje' => 'Esta URL no es correcta'
            ]);
        }

        $usuario->setActivo(true);
        $usuario->setToken(null);
        $entityManager->flush();

        return $this->render('cuentaCreada.html.twig', [
            "email" => $usuario->getCorreo(),
            "mensaje" => ""
        ]);
    }


    #[Route('/cambiarContraseña/{token}', name: 'cambiarcontraseñaConemail')]
public function Cambiar($token, EntityManagerInterface $entityManager)
{
    if (!$token) {
        return $this->render('cuentaCreada.html.twig', [
            'mensaje' => 'Falta el token en la URL'
        ]);
    }

    $usuario = $entityManager->getRepository(Usuarios::class)->findOneBy(['token' => $token]);

    if (!$usuario) {
        return $this->render('cuentaCreada.html.twig', [
            'mensaje' => 'Esta URL no es correcta'
        ]);
    }

    // Pasamos el objeto completo
    return $this->render('contraseñaCambiada.html.twig', [
        'usuario' => $usuario->getToken()
    ]);
}

    #[Route('/nueva', name: 'recibonuevacontraseña')]
    public function nuevaContraseña(
    Request $request, 
    EntityManagerInterface $entityManager, 
    UserPasswordHasherInterface $passwordHasher)
    {
    $token = $request->request->get('token');
    $nuevaContraseña = $request->request->get('nueva');
    $usuario = $entityManager->getRepository(Usuarios::class)->findOneBy(['token' => $token]);

    if (!$usuario) {
        return $this->render('cuentaCreada.html.twig', [
            'mensaje' => 'Usuario no encontrado o token inválido ' . $token . "hola"
        ]);
    }

    $hashedPassword = $passwordHasher->hashPassword($usuario, $nuevaContraseña);
    $usuario->setContraseña($hashedPassword);

    $usuario->setToken(null);

    $entityManager->flush();

    return $this->render('cuentaCreada.html.twig', [
        'mensaje' => 'La contraseña se ha cambiado correctamente'
    ]);
}
}
