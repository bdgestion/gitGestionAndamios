<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Devoluciones
 *
 * @ORM\Table(name="devoluciones", uniqueConstraints={@ORM\UniqueConstraint(name="id_dev", columns={"id_dev"})}, indexes={@ORM\Index(name="IDX_DA538C63C4EC16CE", columns={"pedido"})})
 * @ORM\Entity
 */
class Devoluciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_dev", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDev;

    /**
     * @var integer
     *
     * @ORM\Column(name="pedido", type="integer", nullable=true)
     */
    private $pedido;

    /**
     * @var string
     *
     * @ORM\Column(name="cuenta", type="string", length=200, nullable=false)
     */
    private $cuenta;

    /**
     * @var string
     *
     * @ORM\Column(name="cliente", type="string", length=100, nullable=false)
     */
    private $cliente;

    /**
     * @var string
     *
     * @ORM\Column(name="folio", type="string", length=100, nullable=false)
     */
    private $folio;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_devolucion", type="string", length=100, nullable=false)
     */
    private $fechaDevolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_actual", type="string", length=100, nullable=false)
     */
    private $fechaActual;

    /**
     * @var string
     *
     * @ORM\Column(name="status_pedido", type="string", length=200, nullable=false)
     */
    private $statusPedido;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_entregados", type="integer", nullable=false)
     */
    private $cantidadEntregados;

    /**
     * @var string
     *
     * @ORM\Column(name="clave_equipo", type="string", length=200, nullable=false)
     */
    private $claveEquipo;

    /**
     * @var string
     *
     * @ORM\Column(name="nomb_equipo", type="string", length=200, nullable=false)
     */
    private $nombEquipo;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant_devueltos", type="integer", nullable=false)
     */
    private $cantDevueltos;

    /**
     * @var integer
     *
     * @ORM\Column(name="pendiente_dev", type="integer", nullable=false)
     */
    private $pendienteDev;

    /**
     * @var string
     *
     * @ORM\Column(name="detalles", type="string", length=500, nullable=false)
     */
    private $detalles;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant_dina", type="integer", nullable=false)
     */
    private $cantDina;

    /**
     * @var string
     *
     * @ORM\Column(name="folio_pedido", type="string", length=100, nullable=false)
     */
    private $folioPedido;



    /**
     * Get idDev
     *
     * @return integer
     */
    public function getIdDev()
    {
        return $this->idDev;
    }

    /**
     * Set pedido
     *
     * @param integer $pedido
     *
     * @return Devoluciones
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
     * Set cuenta
     *
     * @param string $cuenta
     *
     * @return Devoluciones
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
     * Set cliente
     *
     * @param string $cliente
     *
     * @return Devoluciones
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
     * Set folio
     *
     * @param string $folio
     *
     * @return Devoluciones
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
     * Set fechaDevolucion
     *
     * @param string $fechaDevolucion
     *
     * @return Devoluciones
     */
    public function setFechaDevolucion($fechaDevolucion)
    {
        $this->fechaDevolucion = $fechaDevolucion;

        return $this;
    }

    /**
     * Get fechaDevolucion
     *
     * @return string
     */
    public function getFechaDevolucion()
    {
        return $this->fechaDevolucion;
    }

    /**
     * Set fechaActual
     *
     * @param string $fechaActual
     *
     * @return Devoluciones
     */
    public function setFechaActual($fechaActual)
    {
        $this->fechaActual = $fechaActual;

        return $this;
    }

    /**
     * Get fechaActual
     *
     * @return string
     */
    public function getFechaActual()
    {
        return $this->fechaActual;
    }

    /**
     * Set statusPedido
     *
     * @param string $statusPedido
     *
     * @return Devoluciones
     */
    public function setStatusPedido($statusPedido)
    {
        $this->statusPedido = $statusPedido;

        return $this;
    }

    /**
     * Get statusPedido
     *
     * @return string
     */
    public function getStatusPedido()
    {
        return $this->statusPedido;
    }

    /**
     * Set cantidadEntregados
     *
     * @param integer $cantidadEntregados
     *
     * @return Devoluciones
     */
    public function setCantidadEntregados($cantidadEntregados)
    {
        $this->cantidadEntregados = $cantidadEntregados;

        return $this;
    }

    /**
     * Get cantidadEntregados
     *
     * @return integer
     */
    public function getCantidadEntregados()
    {
        return $this->cantidadEntregados;
    }

    /**
     * Set claveEquipo
     *
     * @param string $claveEquipo
     *
     * @return Devoluciones
     */
    public function setClaveEquipo($claveEquipo)
    {
        $this->claveEquipo = $claveEquipo;

        return $this;
    }

    /**
     * Get claveEquipo
     *
     * @return string
     */
    public function getClaveEquipo()
    {
        return $this->claveEquipo;
    }

    /**
     * Set nombEquipo
     *
     * @param string $nombEquipo
     *
     * @return Devoluciones
     */
    public function setNombEquipo($nombEquipo)
    {
        $this->nombEquipo = $nombEquipo;

        return $this;
    }

    /**
     * Get nombEquipo
     *
     * @return string
     */
    public function getNombEquipo()
    {
        return $this->nombEquipo;
    }

    /**
     * Set cantDevueltos
     *
     * @param integer $cantDevueltos
     *
     * @return Devoluciones
     */
    public function setCantDevueltos($cantDevueltos)
    {
        $this->cantDevueltos = $cantDevueltos;

        return $this;
    }

    /**
     * Get cantDevueltos
     *
     * @return integer
     */
    public function getCantDevueltos()
    {
        return $this->cantDevueltos;
    }

    /**
     * Set pendienteDev
     *
     * @param integer $pendienteDev
     *
     * @return Devoluciones
     */
    public function setPendienteDev($pendienteDev)
    {
        $this->pendienteDev = $pendienteDev;

        return $this;
    }

    /**
     * Get pendienteDev
     *
     * @return integer
     */
    public function getPendienteDev()
    {
        return $this->pendienteDev;
    }

    /**
     * Set detalles
     *
     * @param string $detalles
     *
     * @return Devoluciones
     */
    public function setDetalles($detalles)
    {
        $this->detalles = $detalles;

        return $this;
    }

    /**
     * Get detalles
     *
     * @return string
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * Set cantDina
     *
     * @param integer $cantDina
     *
     * @return Devoluciones
     */
    public function setCantDina($cantDina)
    {
        $this->cantDina = $cantDina;

        return $this;
    }

    /**
     * Get cantDina
     *
     * @return integer
     */
    public function getCantDina()
    {
        return $this->cantDina;
    }

    /**
     * Set folioPedido
     *
     * @param string $folioPedido
     *
     * @return Devoluciones
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
