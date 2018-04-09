<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HomeTemp
 *
 * @ORM\Table(name="home_temp", indexes={@ORM\Index(name="status_pedido", columns={"status_pedido"}), @ORM\Index(name="status_pago", columns={"status_pago"})})
 * @ORM\Entity
 */
class HomeTemp
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
     * @ORM\Column(name="pedido", type="integer", nullable=false)
     */
    private $pedido;

    /**
     * @var string
     *
     * @ORM\Column(name="folio", type="string", length=20, nullable=false)
     */
    private $folio;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_pedido", type="string", length=500, nullable=false)
     */
    private $fechaPedido;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_dev", type="string", length=500, nullable=false)
     */
    private $fechaDev;

    /**
     * @var string
     *
     * @ORM\Column(name="cliente", type="string", length=500, nullable=false)
     */
    private $cliente;

    /**
     * @var float
     *
     * @ORM\Column(name="saldo", type="float", precision=10, scale=0, nullable=false)
     */
    private $saldo;

    /**
     * @var \StatusEntrega
     *
     * @ORM\ManyToOne(targetEntity="StatusEntrega")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_pedido", referencedColumnName="id")
     * })
     */
    private $statusPedido;

    /**
     * @var \StatusSaldos
     *
     * @ORM\ManyToOne(targetEntity="StatusSaldos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_pago", referencedColumnName="id")
     * })
     */
    private $statusPago;



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
     * Set pedido.
     *
     * @param int $pedido
     *
     * @return HomeTemp
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
     * Set folio.
     *
     * @param string $folio
     *
     * @return HomeTemp
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio.
     *
     * @return string
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set fechaPedido.
     *
     * @param string $fechaPedido
     *
     * @return HomeTemp
     */
    public function setFechaPedido($fechaPedido)
    {
        $this->fechaPedido = $fechaPedido;

        return $this;
    }

    /**
     * Get fechaPedido.
     *
     * @return string
     */
    public function getFechaPedido()
    {
        return $this->fechaPedido;
    }

    /**
     * Set fechaDev.
     *
     * @param string $fechaDev
     *
     * @return HomeTemp
     */
    public function setFechaDev($fechaDev)
    {
        $this->fechaDev = $fechaDev;

        return $this;
    }

    /**
     * Get fechaDev.
     *
     * @return string
     */
    public function getFechaDev()
    {
        return $this->fechaDev;
    }

    /**
     * Set cliente.
     *
     * @param string $cliente
     *
     * @return HomeTemp
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
     * Set saldo.
     *
     * @param float $saldo
     *
     * @return HomeTemp
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo.
     *
     * @return float
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set statusPedido.
     *
     * @param \GestionBundle\Entity\StatusEntrega|null $statusPedido
     *
     * @return HomeTemp
     */
    public function setStatusPedido(\GestionBundle\Entity\StatusEntrega $statusPedido = null)
    {
        $this->statusPedido = $statusPedido;

        return $this;
    }

    /**
     * Get statusPedido.
     *
     * @return \GestionBundle\Entity\StatusEntrega|null
     */
    public function getStatusPedido()
    {
        return $this->statusPedido;
    }

    /**
     * Set statusPago.
     *
     * @param \GestionBundle\Entity\StatusSaldos|null $statusPago
     *
     * @return HomeTemp
     */
    public function setStatusPago(\GestionBundle\Entity\StatusSaldos $statusPago = null)
    {
        $this->statusPago = $statusPago;

        return $this;
    }

    /**
     * Get statusPago.
     *
     * @return \GestionBundle\Entity\StatusSaldos|null
     */
    public function getStatusPago()
    {
        return $this->statusPago;
    }
}
