<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recolecciones
 *
 * @ORM\Table(name="recolecciones")
 * @ORM\Entity
 */
class Recolecciones
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
     * @var int
     *
     * @ORM\Column(name="pedidos", type="integer", nullable=false)
     */
    private $pedidos;

    /**
     * @var string
     *
     * @ORM\Column(name="clientes", type="string", length=500, nullable=false)
     */
    private $clientes;

    /**
     * @var string
     *
     * @ORM\Column(name="obra", type="string", length=500, nullable=false)
     */
    private $obra;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=500, nullable=false)
     */
    private $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha", type="string", length=100, nullable=false)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="hora", type="string", length=100, nullable=false)
     */
    private $hora;



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
     * Set pedidos.
     *
     * @param int $pedidos
     *
     * @return Recolecciones
     */
    public function setPedidos($pedidos)
    {
        $this->pedidos = $pedidos;

        return $this;
    }

    /**
     * Get pedidos.
     *
     * @return int
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * Set clientes.
     *
     * @param string $clientes
     *
     * @return Recolecciones
     */
    public function setClientes($clientes)
    {
        $this->clientes = $clientes;

        return $this;
    }

    /**
     * Get clientes.
     *
     * @return string
     */
    public function getClientes()
    {
        return $this->clientes;
    }

    /**
     * Set obra.
     *
     * @param string $obra
     *
     * @return Recolecciones
     */
    public function setObra($obra)
    {
        $this->obra = $obra;

        return $this;
    }

    /**
     * Get obra.
     *
     * @return string
     */
    public function getObra()
    {
        return $this->obra;
    }

    /**
     * Set domicilio.
     *
     * @param string $domicilio
     *
     * @return Recolecciones
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio.
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set fecha.
     *
     * @param string $fecha
     *
     * @return Recolecciones
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha.
     *
     * @return string
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora.
     *
     * @param string $hora
     *
     * @return Recolecciones
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora.
     *
     * @return string
     */
    public function getHora()
    {
        return $this->hora;
    }
}
