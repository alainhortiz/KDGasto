<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionDepreciacion
 *
 * @ORM\Table(name="plan_estimado_division_depreciacion",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA16", columns={"division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionDepreciacionRepository")
 */
class PlanEstimadoDivisionDepreciacion
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
     * @ORM\Column(name="aprobarPrespuestoDivisionMesDepreciacion", type="boolean")
     */
    private $aprobarPrespuestoDivisionMesDepreciacion = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesDepreciacion", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesDepreciacion = false;

    /**
     * @var int
     *
     * @ORM\Column(name="totalDepreciacion", type="integer",nullable=true)
     */
    private $totalDepreciacion = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoDepreciacionesDivision")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoDepreciacionesDivision")
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
     * Set totalDepreciacion
     *
     * @param integer $totalDepreciacion
     *
     * @return PlanEstimadoDivisionDepreciacion
     */
    public function setTotalDepreciacion($totalDepreciacion)
    {
        $this->totalDepreciacion = $totalDepreciacion;

        return $this;
    }

    /**
     * Get totalDepreciacion
     *
     * @return integer
     */
    public function getTotalDepreciacion()
    {
        return $this->totalDepreciacion;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionDepreciacion
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
     * @return PlanEstimadoDivisionDepreciacion
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

    /**
     * Set aprobarPrespuestoDivisionMesDepreciacion
     *
     * @param boolean $aprobarPrespuestoDivisionMesDepreciacion
     *
     * @return PlanEstimadoDivisionDepreciacion
     */
    public function setAprobarPrespuestoDivisionMesDepreciacion($aprobarPrespuestoDivisionMesDepreciacion)
    {
        $this->aprobarPrespuestoDivisionMesDepreciacion = $aprobarPrespuestoDivisionMesDepreciacion;

        return $this;
    }

    /**
     * Get aprobarPrespuestoDivisionMesDepreciacion
     *
     * @return boolean
     */
    public function getAprobarPrespuestoDivisionMesDepreciacion()
    {
        return $this->aprobarPrespuestoDivisionMesDepreciacion;
    }

    /**
     * Set aprobarPrespuestoCentroCostoMesDepreciacion
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesDepreciacion
     *
     * @return PlanEstimadoDivisionDepreciacion
     */
    public function setAprobarPrespuestoCentroCostoMesDepreciacion($aprobarPrespuestoCentroCostoMesDepreciacion)
    {
        $this->aprobarPrespuestoCentroCostoMesDepreciacion = $aprobarPrespuestoCentroCostoMesDepreciacion;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoMesDepreciacion
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoMesDepreciacion()
    {
        return $this->aprobarPrespuestoCentroCostoMesDepreciacion;
    }
}
