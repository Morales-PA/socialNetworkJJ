<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'comentarios')]
class Comentarios 
{
	#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer', name:'idComentario')]
    private $idComentario;
    
    #[ORM\ManyToOne(targetEntity: Posts::class)]
    #[ORM\JoinColumn(name: 'idPost', referencedColumnName: 'idPost')]
    private $post;

    #[ORM\ManyToOne(targetEntity: Usuarios::class)]
    #[ORM\JoinColumn(name: 'idUsuario', referencedColumnName: 'idUsuario')]
    private $usuario;

    #[ORM\Column(type:'datetime', name:'fechaPublicacion')]
    private $fechaPublicacion;

    #[ORM\Column(type:'string', name:'contenido')]
    private $contenido;
	
    public function getIdComentario() {
        return $this->idComentario;
    }
    
    public function getPost() {
        return $this->post;
    }

    public function setPost($post) {
        $this->post = $post;
    }

    public function getUsuarioDesdeComentarios() {
        return $this->usuario;
    }

    public function setUsuarioDesdeComentarios($usuario) {
        $this->usuario = $usuario;
    }
    
    public function getFechaPublicacion() {
        return $this->fechaPublicacion;
    }
    
    public function setFechaPublicacion($fechaPublicacion) {
        $this->fechaPublicacion = $fechaPublicacion;
    }
    
    public function getContenido() {
        return $this->contenido;
    }
    
    public function setContenido($contenido) {
        $this->contenido = $contenido;
    }
    
}