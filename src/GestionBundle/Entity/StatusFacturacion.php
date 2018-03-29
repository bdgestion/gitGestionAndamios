<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatusFacturacion
 *
 * @ORM\Table(name="status_facturacion", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class StatusFacturacion
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
     * @var string
     *
     * @ORM\Column(name="statusfac", type="string", length=100, nullable=false)
     */
    private $statusfac;



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
     * Set statusfac.
     *
     * @param string $statusfac
     *
     * @return StatusFacturacion
     */
    public function setStatusfac($statusfac)
    {
        $this->statusfac = $statusfac;

        return $this;
    }

    /**
     * Get statusfac.
     *
     * @return string
     */
    public function getStatusfac()
    {
        return $this->statusfac;
    }
}
