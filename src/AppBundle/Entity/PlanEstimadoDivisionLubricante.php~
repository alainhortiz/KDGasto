<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionLubricante
 *
 * @ORM\Table(name="plan_estimado_division_lubricante",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA06", columns={"lubricante_id", "division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionLubricanteRepository")
 */
class PlanEstimadoDivisionLubricante
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
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoDivisionMesLubricante", type="boolean")
     */
    private $aprobarPrespuestoDivisionMesLubricante = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoCentroCostoLubricante", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoLubricante = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesLubricante", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesLubricante = false;

    /**
     * @var int
     *
     * @ORM\Column(name="lts", type="integer",nullable=false)
     */
    private $lts = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="precio", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $precio = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="importe", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $importe = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Lubricante",inversedBy="planEstimadoLubricantes")
     */
    protected $lubricante;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoLubricantes")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoLubricantes")
     */
    protected $planEstimadoIndicadores;

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
     * Set aprobarPrespuestoDivisionMesLubricante
     *
     * @param boolean $aprobarPrespuestoDivisionMesLubricante
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setAprobarPrespuestoDivisionMesLubricante($aprobarPrespuestoDivisionMesLubricante)
    {
        $this->aprobarPrespuestoDivisionMesLubricante = $aprobarPrespuestoDivisionMesLubricante;

        return $this;
    }

    /**
     * Get aprobarPrespuestoDivisionMesLubricante
     *
     * @return boolean
     */
    public function getAprobarPrespuestoDivisionMesLubricante()
    {
        return $this->aprobarPrespuestoDivisionMesLubricante;
    }

    /**
     * Set aprobarPrespuestoCentroCostoLubricante
     *
     * @param boolean $aprobarPrespuestoCentroCostoLubricante
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setAprobarPrespuestoCentroCostoLubricante($aprobarPrespuestoCentroCostoLubricante)
    {
        $this->aprobarPrespuestoCentroCostoLubricante = $aprobarPrespuestoCentroCostoLubricante;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoLubricante
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoLubricante()
    {
        return $this->aprobarPrespuestoCentroCostoLubricante;
    }

    /**
     * Set aprobarPrespuestoCentroCostoMesLubricante
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesLubricante
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setAprobarPrespuestoCentroCostoMesLubricante($aprobarPrespuestoCentroCostoMesLubricante)
    {
        $this->aprobarPrespuestoCentroCostoMesLubricante = $aprobarPrespuestoCentroCostoMesLubricante;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoMesLubricante
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoMesLubricante()
    {
        return $this->aprobarPrespuestoCentroCostoMesLubricante;
    }

    /**
     * Set lts
     *
     * @param integer $lts
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setLts($lts)
    {
        $this->lts = $lts;

        return $this;
    }

    /**
     * Get lts
     *
     * @return integer
     */
    public function getLts()
    {
        return $this->lts;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set lubricante
     *
     * @param \AppBundle\Entity\Lubricante $lubricante
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setLubricante(\AppBundle\Entity\Lubricante $lubricante = null)
    {
        $this->lubricante = $lubricante;

        return $this;
    }

    /**
     * Get lubricante
     *
     * @return \AppBundle\Entity\Lubricante
     */
    public function getLubricante()
    {
        return $this->lubricante;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setDivisionCentroCosto(\AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto = null)
    {
        $this->divisionCentroCosto = $divisionCentroCosto;

        return $this;
    }

    /**
     * Get divisionCentroCosto
     *
     * @return \AppBundle\Entity\DivisionCentroCosto
     */
    public function getDivisionCentroCosto()
    {
        return $this->divisionCentroCosto;
    }

    /**
     * Set planEstimadoIndicadores
     *
     * @param \AppBundle\Entity\PlanEstimadoIndicadores $planEstimadoIndicadores
     *
     * @return PlanEstimadoDivisionLubricante
     */
    public function setPlanEstimadoIndicadores(\AppBundle\Entity\PlanEstimadoIndicadores $planEstimadoIndicadores = null)
    {
        $this->planEstimadoIndicadores = $planEstimadoIndicadores;

        return $this;
    }

    /**
     * Get planEstimadoIndicadores
     *
     * @return \AppBundle\Entity\PlanEstimadoIndicadores
     */
    public function getPlanEstimadoIndicadores()
    {
        return $this->planEstimadoIndicadores;
    }
}
