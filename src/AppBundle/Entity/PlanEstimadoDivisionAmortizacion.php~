<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionAmortizacion
 *
 * @ORM\Table(name="plan_estimado_division_amortizacion",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA19", columns={"division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionAmortizacionRepository")
 */
class PlanEstimadoDivisionAmortizacion
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
     * @ORM\Column(name="aprobarPrespuestoDivisionMesAmortizacion", type="boolean")
     */
    private $aprobarPrespuestoDivisionMesAmortizacion = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesAmortizacion", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesAmortizacion = false;

    /**
     * @var int
     *
     * @ORM\Column(name="totalAmortizacion", type="integer",nullable=true)
     */
    private $totalAmortizacion = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoAmortizacionesDivision")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoAmortizacionesDivision")
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
     * Set aprobarPrespuestoDivisionMesAmortizacion
     *
     * @param boolean $aprobarPrespuestoDivisionMesAmortizacion
     *
     * @return PlanEstimadoDivisionAmortizacion
     */
    public function setAprobarPrespuestoDivisionMesAmortizacion($aprobarPrespuestoDivisionMesAmortizacion)
    {
        $this->aprobarPrespuestoDivisionMesAmortizacion = $aprobarPrespuestoDivisionMesAmortizacion;

        return $this;
    }

    /**
     * Get aprobarPrespuestoDivisionMesAmortizacion
     *
     * @return boolean
     */
    public function getAprobarPrespuestoDivisionMesAmortizacion()
    {
        return $this->aprobarPrespuestoDivisionMesAmortizacion;
    }

    /**
     * Set aprobarPrespuestoCentroCostoMesAmortizacion
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesAmortizacion
     *
     * @return PlanEstimadoDivisionAmortizacion
     */
    public function setAprobarPrespuestoCentroCostoMesAmortizacion($aprobarPrespuestoCentroCostoMesAmortizacion)
    {
        $this->aprobarPrespuestoCentroCostoMesAmortizacion = $aprobarPrespuestoCentroCostoMesAmortizacion;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoMesAmortizacion
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoMesAmortizacion()
    {
        return $this->aprobarPrespuestoCentroCostoMesAmortizacion;
    }

    /**
     * Set totalAmortizacion
     *
     * @param integer $totalAmortizacion
     *
     * @return PlanEstimadoDivisionAmortizacion
     */
    public function setTotalAmortizacion($totalAmortizacion)
    {
        $this->totalAmortizacion = $totalAmortizacion;

        return $this;
    }

    /**
     * Get totalAmortizacion
     *
     * @return integer
     */
    public function getTotalAmortizacion()
    {
        return $this->totalAmortizacion;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionAmortizacion
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
     * @return PlanEstimadoDivisionAmortizacion
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
