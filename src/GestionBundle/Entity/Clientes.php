<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clientes
 *
 * @ORM\Table(name="clientes", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"cliente"})})
 * @ORM\Entity
 */
class Clientes
{
    /**
     * @var int
     *
     * @ORM\Column(name="cliente", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cliente;

    /**
     * @var string
     *
     * @ORM\Column(name="razon_social", type="string", length=500, nullable=false)
     */
    private $razonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="rfc", type="string", length=500, nullable=false)
     */
    private $rfc;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio_fiscal", type="string", length=500, nullable=false)
     */
    private $domicilioFiscal;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=100, nullable=false)
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="comentarios", type="string", length=500, nullable=false)
     */
    private $comentarios;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=100, nullable=false)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=100, nullable=false)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_2", type="string", length=100, nullable=false)
     */
    private $telefono2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="restringir", type="string", length=20, nullable=true)
     */
    private $restringir;

    /**
     * @var string
     *
     * @ORM\Column(name="razon_restriccion", type="string", length=500, nullable=false)
     */
    private $razonRestriccion;



    /**
     * Get cliente.
     *
     * @return int
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set razonSocial.
     *
     * @param string $razonSocial
     *
     * @return Clientes
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial.
     *
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set rfc.
     *
     * @param string $rfc
     *
     * @return Clientes
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc.
     *
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set domicilioFiscal.
     *
     * @param string $domicilioFiscal
     *
     * @return Clientes
     */
    public function setDomicilioFiscal($domicilioFiscal)
    {
        $this->domicilioFiscal = $domicilioFiscal;

        return $this;
    }

    /**
     * Get domicilioFiscal.
     *
     * @return string
     */
    public function getDomicilioFiscal()
    {
        return $this->domicilioFiscal;
    }

    /**
     * Set ciudad.
     *
     * @param string $ciudad
     *
     * @return Clientes
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad.
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set comentarios.
     *
     * @param string $comentarios
     *
     * @return Clientes
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios.
     *
     * @return string
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set correo.
     *
     * @param string $correo
     *
     * @return Clientes
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo.
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set telefono.
     *
     * @param string $telefono
     *
     * @return Clientes
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono.
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set telefono2.
     *
     * @param string $telefono2
     *
     * @return Clientes
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2.
     *
     * @return string
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set restringir.
     *
     * @param string|null $restringir
     *
     * @return Clientes
     */
    public function setRestringir($restringir = null)
    {
        $this->restringir = $restringir;

        return $this;
    }

    /**
     * Get restringir.
     *
     * @return string|null
     */
    public function getRestringir()
    {
        return $this->restringir;
    }

    /**
     * Set razonRestriccion.
     *
     * @param string $razonRestriccion
     *
     * @return Clientes
     */
    public function setRazonRestriccion($razonRestriccion)
    {
        $this->razonRestriccion = $razonRestriccion;

        return $this;
    }

    /**
     * Get razonRestriccion.
     *
     * @return string
     */
    public function getRazonRestriccion()
    {
        return $this->razonRestriccion;
    }
}
