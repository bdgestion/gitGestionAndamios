<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetallesPago
 *
 * @ORM\Table(name="detalles_pago", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="statusfacturacion", columns={"statusfacturacion"}), @ORM\Index(name="formapago", columns={"formapago"})})
 * @ORM\Entity
 */
class DetallesPago
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
     * @var int|null
     *
     * @ORM\Column(name="pedido", type="integer", nullable=true)
     */
    private $pedido;

    /**
     * @var string
     *
     * @ORM\Column(name="fechapago", type="string", length=100, nullable=false)
     */
    private $fechapago;

    /**
     * @var float
     *
     * @ORM\Column(name="montopago", type="float", precision=10, scale=0, nullable=false)
     */
    private $montopago;

    /**
     * @var string
     *
     * @ORM\Column(name="comentariopago", type="string", length=500, nullable=false)
     */
    private $comentariopago;

    /**
     * @var string
     *
     * @ORM\Column(name="foliofactura", type="string", length=100, nullable=false)
     */
    private $foliofactura;

    /**
     * @var string
     *
     * @ORM\Column(name="operacion", type="string", length=100, nullable=false)
     */
    private $operacion;

    /**
     * @var float
     *
     * @ORM\Column(name="saldo_restante", type="float", precision=10, scale=0, nullable=false)
     */
    private $saldoRestante;

    /**
     * @var \StatusFacturacion
     *
     * @ORM\ManyToOne(targetEntity="StatusFacturacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="statusfacturacion", referencedColumnName="id")
     * })
     */
    private $statusfacturacion;

    /**
     * @var \FormasPagos
     *
     * @ORM\ManyToOne(targetEntity="FormasPagos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formapago", referencedColumnName="id")
     * })
     */
    private $formapago;



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
     * @param int|null $pedido
     *
     * @return DetallesPago
     */
    public function setPedido($pedido = null)
    {
        $this->pedido = $pedido;

        return $this;
    }

    /**
     * Get pedido.
     *
     * @return int|null
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set fechapago.
     *
     * @param string $fechapago
     *
     * @return DetallesPago
     */
    public function setFechapago($fechapago)
    {
        $this->fechapago = $fechapago;

        return $this;
    }

    /**
     * Get fechapago.
     *
     * @return string
     */
    public function getFechapago()
    {
        return $this->fechapago;
    }

    /**
     * Set montopago.
     *
     * @param float $montopago
     *
     * @return DetallesPago
     */
    public function setMontopago($montopago)
    {
        $this->montopago = $montopago;

        return $this;
    }

    /**
     * Get montopago.
     *
     * @return float
     */
    public function getMontopago()
    {
        return $this->montopago;
    }

    /**
     * Set comentariopago.
     *
     * @param string $comentariopago
     *
     * @return DetallesPago
     */
    public function setComentariopago($comentariopago)
    {
        $this->comentariopago = $comentariopago;

        return $this;
    }

    /**
     * Get comentariopago.
     *
     * @return string
     */
    public function getComentariopago()
    {
        return $this->comentariopago;
    }

    /**
     * Set foliofactura.
     *
     * @param string $foliofactura
     *
     * @return DetallesPago
     */
    public function setFoliofactura($foliofactura)
    {
        $this->foliofactura = $foliofactura;

        return $this;
    }

    /**
     * Get foliofactura.
     *
     * @return string
     */
    public function getFoliofactura()
    {
        return $this->foliofactura;
    }

    /**
     * Set operacion.
     *
     * @param string $operacion
     *
     * @return DetallesPago
     */
    public function setOperacion($operacion)
    {
        $this->operacion = $operacion;

        return $this;
    }

    /**
     * Get operacion.
     *
     * @return string
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * Set saldoRestante.
     *
     * @param float $saldoRestante
     *
     * @return DetallesPago
     */
    public function setSaldoRestante($saldoRestante)
    {
        $this->saldoRestante = $saldoRestante;

        return $this;
    }

    /**
     * Get saldoRestante.
     *
     * @return float
     */
    public function getSaldoRestante()
    {
        return $this->saldoRestante;
    }

    /**
     * Set statusfacturacion.
     *
     * @param \GestionBundle\Entity\StatusFacturacion|null $statusfacturacion
     *
     * @return DetallesPago
     */
    public function setStatusfacturacion(\GestionBundle\Entity\StatusFacturacion $statusfacturacion = null)
    {
        $this->statusfacturacion = $statusfacturacion;

        return $this;
    }

    /**
     * Get statusfacturacion.
     *
     * @return \GestionBundle\Entity\StatusFacturacion|null
     */
    public function getStatusfacturacion()
    {
        return $this->statusfacturacion;
    }

    /**
     * Set formapago.
     *
     * @param \GestionBundle\Entity\FormasPagos|null $formapago
     *
     * @return DetallesPago
     */
    public function setFormapago(\GestionBundle\Entity\FormasPagos $formapago = null)
    {
        $this->formapago = $formapago;

        return $this;
    }

    /**
     * Get formapago.
     *
     * @return \GestionBundle\Entity\FormasPagos|null
     */
    public function getFormapago()
    {
        return $this->formapago;
    }
}
