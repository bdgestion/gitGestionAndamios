<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Montospedidos
 *
 * @ORM\Table(name="montospedidos", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}), @ORM\UniqueConstraint(name="pedido", columns={"pedido"})}, indexes={@ORM\Index(name="statussaldo", columns={"statussaldo"})})
 * @ORM\Entity
 */
class Montospedidos
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
     * @var float
     *
     * @ORM\Column(name="montopedido", type="float", precision=10, scale=0, nullable=false)
     */
    private $montopedido;

    /**
     * @var int
     *
     * @ORM\Column(name="pedido", type="integer", nullable=false)
     */
    private $pedido;

    /**
     * @var float
     *
     * @ORM\Column(name="saldorestante", type="float", precision=10, scale=0, nullable=false)
     */
    private $saldorestante;

    /**
     * @var \StatusSaldos
     *
     * @ORM\ManyToOne(targetEntity="StatusSaldos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="statussaldo", referencedColumnName="id")
     * })
     */
    private $statussaldo;



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
     * Set montopedido.
     *
     * @param float $montopedido
     *
     * @return Montospedidos
     */
    public function setMontopedido($montopedido)
    {
        $this->montopedido = $montopedido;

        return $this;
    }

    /**
     * Get montopedido.
     *
     * @return float
     */
    public function getMontopedido()
    {
        return $this->montopedido;
    }

    /**
     * Set pedido.
     *
     * @param int $pedido
     *
     * @return Montospedidos
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
     * Set saldorestante.
     *
     * @param float $saldorestante
     *
     * @return Montospedidos
     */
    public function setSaldorestante($saldorestante)
    {
        $this->saldorestante = $saldorestante;

        return $this;
    }

    /**
     * Get saldorestante.
     *
     * @return float
     */
    public function getSaldorestante()
    {
        return $this->saldorestante;
    }

    /**
     * Set statussaldo.
     *
     * @param \GestionBundle\Entity\StatusSaldos|null $statussaldo
     *
     * @return Montospedidos
     */
    public function setStatussaldo(\GestionBundle\Entity\StatusSaldos $statussaldo = null)
    {
        $this->statussaldo = $statussaldo;

        return $this;
    }

    /**
     * Get statussaldo.
     *
     * @return \GestionBundle\Entity\StatusSaldos|null
     */
    public function getStatussaldo()
    {
        return $this->statussaldo;
    }
}
