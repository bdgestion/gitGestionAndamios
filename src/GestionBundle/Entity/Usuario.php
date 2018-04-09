<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity
 */
class Usuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", length=50, nullable=false)
     */
    private $clave;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_usuario", type="string", length=50, nullable=false)
     */
    private $nombreUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=500, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=500, nullable=false)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=100, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_creacion", type="string", length=100, nullable=false)
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_ultimo_ingreso", type="string", length=100, nullable=false)
     */
    private $fechaUltimoIngreso;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=100, nullable=false)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="string", length=500, nullable=false)
     */
    private $comentario;



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set clave.
     *
     * @param string $clave
     *
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave.
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set nombreUsuario.
     *
     * @param string $nombreUsuario
     *
     * @return Usuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    /**
     * Get nombreUsuario.
     *
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido.
     *
     * @param string $apellido
     *
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido.
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Usuario
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set fechaCreacion.
     *
     * @param string $fechaCreacion
     *
     * @return Usuario
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion.
     *
     * @return string
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaUltimoIngreso.
     *
     * @param string $fechaUltimoIngreso
     *
     * @return Usuario
     */
    public function setFechaUltimoIngreso($fechaUltimoIngreso)
    {
        $this->fechaUltimoIngreso = $fechaUltimoIngreso;

        return $this;
    }

    /**
     * Get fechaUltimoIngreso.
     *
     * @return string
     */
    public function getFechaUltimoIngreso()
    {
        return $this->fechaUltimoIngreso;
    }

    /**
     * Set tipo.
     *
     * @param string $tipo
     *
     * @return Usuario
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set comentario.
     *
     * @param string $comentario
     *
     * @return Usuario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario.
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }
}
