<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Impuestos
 *
 * @ORM\Table(name="impuestos", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Impuestos
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=500, nullable=false)
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=false)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=500, nullable=false)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="calculo", type="string", length=500, nullable=false)
     */
    private $calculo;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=500, nullable=false)
     */
    private $status;



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
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return Impuestos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set valor.
     *
     * @param float $valor
     *
     * @return Impuestos
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor.
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set tipo.
     *
     * @param string $tipo
     *
     * @return Impuestos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set calculo.
     *
     * @param string $calculo
     *
     * @return Impuestos
     */
    public function setCalculo($calculo)
    {
        $this->calculo = $calculo;

        return $this;
    }

    /**
     * Get calculo.
     *
     * @return string
     */
    public function getCalculo()
    {
        return $this->calculo;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Impuestos
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
