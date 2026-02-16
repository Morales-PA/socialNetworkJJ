<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'usuarios')]
class Usuarios 
{
	#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer', name:'idUsuario')]
    private $idUsuario;
    
	#[ORM\Column(type:'string', name:'nombre')]
    private $nombre;

    #[ORM\Column(type:'string', name:'correo', unique:true)]
    private $correo;

	#[ORM\Column(type:'string', name:'contraseña')]
    private $contraseña;

    #[ORM\Column(type:'boolean', name:'admin')]
    private $admin;

    #[ORM\Column(type:'boolean', name:'activo')]
    private $activo;

    #[ORM\Column(type:'datetime', name:'fechaRegistro')]
    private $fechaRegistro;
	
    public function getIdUsuario() {
        return $this->idUsuario;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function getCorreo() {
        return $this->correo;
    }
    
    public function setCorreo($correo) {
        $this->correo = $correo;
    }
    
    public function getContraseña() {
        return $this->contraseña;
    }
    
    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }
    
    public function getAdmin() {
        return $this->admin;
    }
    
    public function setAdmin($admin) {
        $this->admin = $admin;
    }
    
    public function getActivo() {
        return $this->activo;
    }
    
    public function setActivo($activo) {
        $this->activo = $activo;
    }
    
    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
}