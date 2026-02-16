<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'seguidores')]
class Seguidores 
{
	#[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Usuarios::class)]
    #[ORM\JoinColumn(name: 'idSeguidor', referencedColumnName: 'idUsuario', nullable: false)]
    private $seguidor;
    
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Usuarios::class)]
    #[ORM\JoinColumn(name: 'idSeguido', referencedColumnName: 'idUsuario', nullable: false)]
    private $seguido;

	#[ORM\Column(type:'string', name:'estado')]
    private $estado;
	
    public function getIdSeguidor() {
        return $this->idSeguidor;
    }
    public function getIdSeguido() {
        return $this->idSeguido;
    }
    public function setIdSeguido($idSeguido) {
        $this->idSeguido = $idSeguido;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }
}