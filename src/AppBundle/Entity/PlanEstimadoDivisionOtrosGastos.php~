<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionOtrosGastos
 *
 * @ORM\Table(name="plan_estimado_division_otros_gastos",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA22", columns={"otro_gasto_id","division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionOtrosGastosRepository")
 */
class PlanEstimadoDivisionOtrosGastos
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
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesOtroGasto", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesOtroGasto = false;

    /**
     * @var int
     *
     * @ORM\Column(name="totalOtroGasto", type="integer",nullable=true)
     */
    private $totalOtroGasto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="OtroGasto",inversedBy="planEstimadosDivisionesOtrosGastos")
     */
    protected $otroGasto;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadosDivisionesOtrosGastos")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadosDivisionesOtrosGastos")
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
     * Set aprobarPrespuestoCentroCostoMesOtroGasto
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesOtroGasto
     *
     * @return PlanEstimadoDivisionOtrosGastos
     */
    public function setAprobarPrespuestoCentroCostoMesOtroGasto($aprobarPrespuestoCentroCostoMesOtroGasto)
    {
        $this->aprobarPrespuestoCentroCostoMesOtroGasto = $aprobarPrespuestoCentroCostoMesOtroGasto;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoMesOtroGasto
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoMesOtroGasto()
    {
        return $this->aprobarPrespuestoCentroCostoMesOtroGasto;
    }

    /**
     * Set totalOtroGasto
     *
     * @param integer $totalOtroGasto
     *
     * @return PlanEstimadoDivisionOtrosGastos
     */
    public function setTotalOtroGasto($totalOtroGasto)
    {
        $this->totalOtroGasto = $totalOtroGasto;

        return $this;
    }

    /**
     * Get totalOtroGasto
     *
     * @return integer
     */
    public function getTotalOtroGasto()
    {
        return $this->totalOtroGasto;
    }

    /**
     * Set otroGasto
     *
     * @param \AppBundle\Entity\OtroGasto $otroGasto
     *
     * @return PlanEstimadoDivisionOtrosGastos
     */
    public function setOtroGasto(\AppBundle\Entity\OtroGasto $otroGasto = null)
    {
        $this->otroGasto = $otroGasto;

        return $this;
    }

    /**
     * Get otroGasto
     *
     * @return \AppBundle\Entity\OtroGasto
     */
    public function getOtroGasto()
    {
        return $this->otroGasto;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionOtrosGastos
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
     * @return PlanEstimadoDivisionOtrosGastos
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
