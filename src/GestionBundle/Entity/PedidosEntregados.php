<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PedidosEntregados
 *
 * @ORM\Table(name="pedidos_entregados", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="statuspedido", columns={"statuspedido"})})
 * @ORM\Entity
 */
class PedidosEntregados
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="foliofisico", type="integer", nullable=false)
     */
    private $foliofisico;

    /**
     * @var string
     *
     * @ORM\Column(name="fechafolio", type="string", length=100, nullable=false)
     */
    private $fechafolio;

    /**
     * @var int
     *
     * @ORM\Column(name="pedido", type="integer", nullable=false)
     */
    private $pedido;

    /**
     * @var \StatusEntrega
     *
     * @ORM\ManyToOne(targetEntity="StatusEntrega")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="statuspedido", referencedColumnName="id")
     * })
     */
    private $statuspedido;



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
     * Set foliofisico.
     *
     * @param int $foliofisico
     *
     * @return PedidosEntregados
     */
    public function setFoliofisico($foliofisico)
    {
        $this->foliofisico = $foliofisico;

        return $this;
    }

    /**
     * Get foliofisico.
     *
     * @return int
     */
    public function getFoliofisico()
    {
        return $this->foliofisico;
    }

    /**
     * Set fechafolio.
     *
     * @param string $fechafolio
     *
     * @return PedidosEntregados
     */
    public function setFechafolio($fechafolio)
    {
        $this->fechafolio = $fechafolio;

        return $this;
    }

    /**
     * Get fechafolio.
     *
     * @return string
     */
    public function getFechafolio()
    {
        return $this->fechafolio;
    }

    /**
     * Set pedido.
     *
     * @param int $pedido
     *
     * @return PedidosEntregados
     */
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;

        return $this;
    }

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
     * Set statuspedido.
     *
     * @param \GestionBundle\Entity\StatusEntrega|null $statuspedido
     *
     * @return PedidosEntregados
     */
    public function setStatuspedido(\GestionBundle\Entity\StatusEntrega $statuspedido = null)
    {
        $this->statuspedido = $statuspedido;

        return $this;
    }

    /**
     * Get statuspedido.
     *
     * @return \GestionBundle\Entity\StatusEntrega|null
     */
    public function getStatuspedido()
    {
        return $this->statuspedido;
    }
}
