<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatusSaldos
 *
 * @ORM\Table(name="status_saldos", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class StatusSaldos
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
     * @ORM\Column(name="statussaldos", type="string", length=100, nullable=false)
     */
    private $statussaldos;



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
     * Set statussaldos.
     *
     * @param string $statussaldos
     *
     * @return StatusSaldos
     */
    public function setStatussaldos($statussaldos)
    {
        $this->statussaldos = $statussaldos;

        return $this;
    }

    /**
     * Get statussaldos.
     *
     * @return string
     */
    public function getStatussaldos()
    {
        return $this->statussaldos;
    }
}
