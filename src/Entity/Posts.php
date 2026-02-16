<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'posts')]
class Posts 
{
	#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer', name:'idPost')]
    private $idPost;
    
    #[ORM\ManyToOne(targetEntity: Usuarios::class)]
    #[ORM\JoinColumn(name: 'idUsuario', referencedColumnName: 'idUsuario')]
    private $usuario;

    #[ORM\Column(type:'datetime', name:'fechaPublicacion')]
    private $fechaPublicacion;

    #[ORM\Column(type:'string', name:'contenido')]
    private $contenido;
	
    public function getIdPost() {
        return $this->idPost;
    }
    
    public function getUsuarioDesdePost() {
        return $this->usuario;
    }

    public function setUsuarioDesdePost($usuario) {
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