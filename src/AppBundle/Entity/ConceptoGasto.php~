<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ConceptoGasto
 *
 * @ORM\Table(name="concepto_gasto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConceptoGastoRepository")
 */
class ConceptoGasto
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=150)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="precioCosto", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $precioCosto = 0;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaInicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaFinal", type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\OneToMany(targetEntity="FichaCosto", mappedBy="conceptoGasto")
     */
    private $fichasCostos;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->fichasCostos = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return ConceptoGasto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set precioCosto
     *
     * @param string $precioCosto
     *
     * @return ConceptoGasto
     */
    public function setPrecioCosto($precioCosto)
    {
        $this->precioCosto = $precioCosto;

        return $this;
    }

    /**
     * Get precioCosto
     *
     * @return string
     */
    public function getPrecioCosto()
    {
        return $this->precioCosto;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return ConceptoGasto
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return ConceptoGasto
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return ConceptoGasto
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add fichasCosto
     *
     * @param \AppBundle\Entity\FichaCosto $fichasCosto
     *
     * @return ConceptoGasto
     */
    public function addFichasCosto(\AppBundle\Entity\FichaCosto $fichasCosto)
    {
        $this->fichasCostos[] = $fichasCosto;

        return $this;
    }

    /**
     * Remove fichasCosto
     *
     * @param \AppBundle\Entity\FichaCosto $fichasCosto
     */
    public function removeFichasCosto(\AppBundle\Entity\FichaCosto $fichasCosto)
    {
        $this->fichasCostos->removeElement($fichasCosto);
    }

    /**
     * Get fichasCostos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFichasCostos()
    {
        return $this->fichasCostos;
    }
}
