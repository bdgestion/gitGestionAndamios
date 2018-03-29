<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentasCliente
 *
 * @ORM\Table(name="cuentas_cliente", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}), @ORM\UniqueConstraint(name="cuenta_id", columns={"cuenta_id"})})
 * @ORM\Entity
 */
class CuentasCliente
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
     * @ORM\Column(name="cliente", type="integer", nullable=false)
     */
    private $cliente;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comentarios", type="string", length=120, nullable=true)
     */
    private $comentarios;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=100, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=120, nullable=false)
     */
    private $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="cuenta_id", type="string", length=10, nullable=false)
     */
    private $cuentaId;



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
     * Set cliente.
     *
     * @param int $cliente
     *
     * @return CuentasCliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

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
     * Set comentarios.
     *
     * @param string|null $comentarios
     *
     * @return CuentasCliente
     */
    public function setComentarios($comentarios = null)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios.
     *
     * @return string|null
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set status.
     *
     * @param string|null $status
     *
     * @return CuentasCliente
     */
    public function setStatus($status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set domicilio.
     *
     * @param string $domicilio
     *
     * @return CuentasCliente
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
     * Set cuentaId.
     *
     * @param string $cuentaId
     *
     * @return CuentasCliente
     */
    public function setCuentaId($cuentaId)
    {
        $this->cuentaId = $cuentaId;

        return $this;
    }

    /**
     * Get cuentaId.
     *
     * @return string
     */
    public function getCuentaId()
    {
        return $this->cuentaId;
    }
}
