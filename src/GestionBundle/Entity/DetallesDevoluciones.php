<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetallesDevoluciones
 *
 * @ORM\Table(name="detalles_devoluciones", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class DetallesDevoluciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="pedidosistema", type="integer", nullable=false)
     */
    private $pedidosistema;

    /**
     * @var integer
     *
     * @ORM\Column(name="foliopadre", type="integer", nullable=false)
     */
    private $foliopadre;

    /**
     * @var integer
     *
     * @ORM\Column(name="foliodevolucion", type="integer", nullable=false)
     */
    private $foliodevolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="fechamovimiento", type="string", length=100, nullable=false)
     */
    private $fechamovimiento;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad", type="float", precision=10, scale=0, nullable=false)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="claveequipo", type="string", length=100, nullable=false)
     */
    private $claveequipo;

    /**
     * @var string
     *
     * @ORM\Column(name="equipo", type="string", length=100, nullable=false)
     */
    private $equipo;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pedidosistema
     *
     * @param integer $pedidosistema
     *
     * @return DetallesDevoluciones
     */
    public function setPedidosistema($pedidosistema)
    {
        $this->pedidosistema = $pedidosistema;

        return $this;
    }

    /**
     * Get pedidosistema
     *
     * @return integer
     */
    public function getPedidosistema()
    {
        return $this->pedidosistema;
    }

    /**
     * Set foliopadre
     *
     * @param integer $foliopadre
     *
     * @return DetallesDevoluciones
     */
    public function setFoliopadre($foliopadre)
    {
        $this->foliopadre = $foliopadre;

        return $this;
    }

    /**
     * Get foliopadre
     *
     * @return integer
     */
    public function getFoliopadre()
    {
        return $this->foliopadre;
    }

    /**
     * Set foliodevolucion
     *
     * @param integer $foliodevolucion
     *
     * @return DetallesDevoluciones
     */
    public function setFoliodevolucion($foliodevolucion)
    {
        $this->foliodevolucion = $foliodevolucion;

        return $this;
    }

    /**
     * Get foliodevolucion
     *
     * @return integer
     */
    public function getFoliodevolucion()
    {
        return $this->foliodevolucion;
    }

    /**
     * Set fechamovimiento
     *
     * @param string $fechamovimiento
     *
     * @return DetallesDevoluciones
     */
    public function setFechamovimiento($fechamovimiento)
    {
        $this->fechamovimiento = $fechamovimiento;

        return $this;
    }

    /**
     * Get fechamovimiento
     *
     * @return string
     */
    public function getFechamovimiento()
    {
        return $this->fechamovimiento;
    }

    /**
     * Set cantidad
     *
     * @param float $cantidad
     *
     * @return DetallesDevoluciones
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return float
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set claveequipo
     *
     * @param string $claveequipo
     *
     * @return DetallesDevoluciones
     */
    public function setClaveequipo($claveequipo)
    {
        $this->claveequipo = $claveequipo;

        return $this;
    }

    /**
     * Get claveequipo
     *
     * @return string
     */
    public function getClaveequipo()
    {
        return $this->claveequipo;
    }

    /**
     * Set equipo
     *
     * @param string $equipo
     *
     * @return DetallesDevoluciones
     */
    public function setEquipo($equipo)
    {
        $this->equipo = $equipo;

        return $this;
    }

    /**
     * Get equipo
     *
     * @return string
     */
    public function getEquipo()
    {
        return $this->equipo;
    }
}
