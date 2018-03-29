<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ultpedido
 *
 * @ORM\Table(name="ultpedido", uniqueConstraints={@ORM\UniqueConstraint(name="pedido", columns={"pedido"})})
 * @ORM\Entity
 */
class Ultpedido
{
    /**
     * @var int
     *
     * @ORM\Column(name="pedido", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pedido;

    /**
     * @var string
     *
     * @ORM\Column(name="cliente", type="string", length=500, nullable=false)
     */
    private $cliente;

    /**
     * @var string
     *
     * @ORM\Column(name="obra", type="string", length=500, nullable=false)
     */
    private $obra;



    /**
     * Get pedido.
     *
     * @return int
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set cliente.
     *
     * @param string $cliente
     *
     * @return Ultpedido
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente.
     *
     * @return string
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set obra.
     *
     * @param string $obra
     *
     * @return Ultpedido
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
}
