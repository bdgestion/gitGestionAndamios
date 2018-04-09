<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormasPagos
 *
 * @ORM\Table(name="formas_pagos", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class FormasPagos
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
     * @ORM\Column(name="formas", type="string", length=100, nullable=false)
     */
    private $formas;



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
     * Set formas.
     *
     * @param string $formas
     *
     * @return FormasPagos
     */
    public function setFormas($formas)
    {
        $this->formas = $formas;

        return $this;
    }

    /**
     * Get formas.
     *
     * @return string
     */
    public function getFormas()
    {
        return $this->formas;
    }
}
