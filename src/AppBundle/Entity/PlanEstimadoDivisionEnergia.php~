<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionEnergia
 *
 * @ORM\Table(name="plan_estimado_division_energia",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA09", columns={"division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionEnergiaRepository")
 */
class PlanEstimadoDivisionEnergia
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
     * @ORM\Column(name="aprobarPrespuestoDivisionMesEnergia", type="boolean")
     */
    private $aprobarPrespuestoDivisionMesEnergia = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesEnergia", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesEnergia = false;

    /**
     * @var int
     *
     * @ORM\Column(name="totalKWDivision", type="integer",nullable=true)
     */
    private $totalKWDivision = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="totalEnergiaPresupuesto",  type="decimal", precision=18, scale=2, nullable=true)
     */
    private $totalEnergiaPresupuesto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoEnergias")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoEnergias")
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
     * Set aprobarPrespuestoDivisionMesEnergia
     *
     * @param boolean $aprobarPrespuestoDivisionMesEnergia
     *
     * @return PlanEstimadoDivisionEnergia
     */
    public function setAprobarPrespuestoDivisionMesEnergia($aprobarPrespuestoDivisionMesEnergia)
    {
        $this->aprobarPrespuestoDivisionMesEnergia = $aprobarPrespuestoDivisionMesEnergia;

        return $this;
    }

    /**
     * Get aprobarPrespuestoDivisionMesEnergia
     *
     * @return boolean
     */
    public function getAprobarPrespuestoDivisionMesEnergia()
    {
        return $this->aprobarPrespuestoDivisionMesEnergia;
    }

    /**
     * Set aprobarPrespuestoCentroCostoMesEnergia
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesEnergia
     *
     * @return PlanEstimadoDivisionEnergia
     */
    public function setAprobarPrespuestoCentroCostoMesEnergia($aprobarPrespuestoCentroCostoMesEnergia)
    {
        $this->aprobarPrespuestoCentroCostoMesEnergia = $aprobarPrespuestoCentroCostoMesEnergia;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoMesEnergia
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoMesEnergia()
    {
        return $this->aprobarPrespuestoCentroCostoMesEnergia;
    }

    /**
     * Set totalKWDivision
     *
     * @param integer $totalKWDivision
     *
     * @return PlanEstimadoDivisionEnergia
     */
    public function setTotalKWDivision($totalKWDivision)
    {
        $this->totalKWDivision = $totalKWDivision;

        return $this;
    }

    /**
     * Get totalKWDivision
     *
     * @return integer
     */
    public function getTotalKWDivision()
    {
        return $this->totalKWDivision;
    }

    /**
     * Set totalEnergiaPresupuesto
     *
     * @param string $totalEnergiaPresupuesto
     *
     * @return PlanEstimadoDivisionEnergia
     */
    public function setTotalEnergiaPresupuesto($totalEnergiaPresupuesto)
    {
        $this->totalEnergiaPresupuesto = $totalEnergiaPresupuesto;

        return $this;
    }

    /**
     * Get totalEnergiaPresupuesto
     *
     * @return string
     */
    public function getTotalEnergiaPresupuesto()
    {
        return $this->totalEnergiaPresupuesto;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionEnergia
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
     * @return PlanEstimadoDivisionEnergia
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
