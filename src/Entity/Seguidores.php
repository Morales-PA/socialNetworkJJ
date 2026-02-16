<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'seguidores')]
class Seguidores 
{
	#[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Usuarios::class)]
    #[ORM\JoinColumn(name: 'idSeguidor', referencedColumnName: 'idUsuario')]
    private $seguidor;
    
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Usuarios::class)]
    #[ORM\JoinColumn(name: 'idSeguido', referencedColumnName: 'idUsuario')]
    private $seguido;

	#[ORM\Column(type:'string', name:'estado')]
    private $estado;
	
    public function getSeguidor() {
        return $this->seguidor;
    }
    public function getSeguido() {
        return $this->seguido;
    }
    public function setSeguido($seguido) {
        $this->seguido = $seguido;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }
}