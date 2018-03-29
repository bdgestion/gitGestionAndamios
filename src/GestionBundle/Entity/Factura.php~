<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factura
 *
 * @ORM\Table(name="factura", uniqueConstraints={@ORM\UniqueConstraint(name="Op_ID", columns={"Op_ID"})})
 * @ORM\Entity
 */
class Factura
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pedido", type="integer", nullable=false)
     */
    private $pedido;

    /**
     * @var string
     *
     * @ORM\Column(name="folio", type="string", length=50, nullable=false)
     */
    private $folio;

    /**
     * @var string
     *
     * @ORM\Column(name="cliente", type="string", length=100, nullable=false)
     */
    private $cliente;

    /**
     * @var string
     *
     * @ORM\Column(name="cuenta", type="string", length=200, nullable=false)
     */
    private $cuenta;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_pago", type="string", length=100, nullable=false)
     */
    private $fechaPago;

    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=false)
     */
    private $monto;

    /**
     * @var string
     *
     * @ORM\Column(name="forma_pago", type="string", length=100, nullable=false)
     */
    private $formaPago;

    /**
     * @var string
     *
     * @ORM\Column(name="facturacion", type="string", length=100, nullable=true)
     */
    private $facturacion;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=100, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="status_financiero", type="string", length=100, nullable=false)
     */
    private $statusFinanciero;

    /**
     * @var float
     *
     * @ORM\Column(name="cargo_pedido", type="float", precision=10, scale=0, nullable=false)
     */
    private $cargoPedido;

    /**
     * @var string
     *
     * @ORM\Column(name="devolucion", type="string", length=400, nullable=false)
     */
    private $devolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="string", length=500, nullable=false)
     */
    private $comentario;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=100, nullable=false)
     */
    private $tipo;

    /**
     * @var float
     *
     * @ORM\Column(name="saldo", type="float", precision=10, scale=0, nullable=true)
     */
    private $saldo;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha", type="string", length=100, nullable=false)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="Op_ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $opId;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_emision", type="string", length=100, nullable=true)
     */
    private $fechaEmision;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="folio_pedido", type="string", length=100, nullable=false)
     */
    private $folioPedido;



    /**
     * Set pedido
     *
     * @param integer $pedido
     *
     * @return Factura
     */
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;

        return $this;
    }

    /**
     * Get pedido
     *
     * @return integer
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set folio
     *
     * @param string $folio
     *
     * @return Factura
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio
     *
     * @return string
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set cliente
     *
     * @param string $cliente
     *
     * @return Factura
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return string
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set cuenta
     *
     * @param string $cuenta
     *
     * @return Factura
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return string
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set fechaPago
     *
     * @param string $fechaPago
     *
     * @return Factura
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return string
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set monto
     *
     * @param float $monto
     *
     * @return Factura
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set formaPago
     *
     * @param string $formaPago
     *
     * @return Factura
     */
    public function setFormaPago($formaPago)
    {
        $this->formaPago = $formaPago;

        return $this;
    }

    /**
     * Get formaPago
     *
     * @return string
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }

    /**
     * Set facturacion
     *
     * @param string $facturacion
     *
     * @return Factura
     */
    public function setFacturacion($facturacion)
    {
        $this->facturacion = $facturacion;

        return $this;
    }

    /**
     * Get facturacion
     *
     * @return string
     */
    public function getFacturacion()
    {
        return $this->facturacion;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Factura
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set statusFinanciero
     *
     * @param string $statusFinanciero
     *
     * @return Factura
     */
    public function setStatusFinanciero($statusFinanciero)
    {
        $this->statusFinanciero = $statusFinanciero;

        return $this;
    }

    /**
     * Get statusFinanciero
     *
     * @return string
     */
    public function getStatusFinanciero()
    {
        return $this->statusFinanciero;
    }

    /**
     * Set cargoPedido
     *
     * @param float $cargoPedido
     *
     * @return Factura
     */
    public function setCargoPedido($cargoPedido)
    {
        $this->cargoPedido = $cargoPedido;

        return $this;
    }

    /**
     * Get cargoPedido
     *
     * @return float
     */
    public function getCargoPedido()
    {
        return $this->cargoPedido;
    }

    /**
     * Set devolucion
     *
     * @param string $devolucion
     *
     * @return Factura
     */
    public function setDevolucion($devolucion)
    {
        $this->devolucion = $devolucion;

        return $this;
    }

    /**
     * Get devolucion
     *
     * @return string
     */
    public function getDevolucion()
    {
        return $this->devolucion;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return Factura
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Factura
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set saldo
     *
     * @param float $saldo
     *
     * @return Factura
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return float
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set fecha
     *
     * @param string $fecha
     *
     * @return Factura
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return string
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Get opId
     *
     * @return integer
     */
    public function getOpId()
    {
        return $this->opId;
    }

    /**
     * Set fechaEmision
     *
     * @param string $fechaEmision
     *
     * @return Factura
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * Get fechaEmision
     *
     * @return string
     */
    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return Factura
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set folioPedido
     *
     * @param string $folioPedido
     *
     * @return Factura
     */
    public function setFolioPedido($folioPedido)
    {
        $this->folioPedido = $folioPedido;

        return $this;
    }

    /**
     * Get folioPedido
     *
     * @return string
     */
    public function getFolioPedido()
    {
        return $this->folioPedido;
    }
}
