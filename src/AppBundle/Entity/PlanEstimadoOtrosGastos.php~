<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoOtrosGastos
 *
 * @ORM\Table(name="plan_estimado_otros_gastos",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA11", columns={"otro_gasto_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoOtrosGastosRepository")
 */
class PlanEstimadoOtrosGastos
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
     * @ORM\Column(name="aprobarPrespuestoMesOtroGasto", type="boolean")
     */
    private $aprobarPrespuestoMesOtroGasto = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesOtroGasto", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesOtroGasto = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoDivisionMesOtroGasto", type="boolean")
     */
    private $aprobarPrespuestoDivisionMesOtroGasto = false;

    /**
     * @var int
     *
     * @ORM\Column(name="totalOtroGasto", type="integer",nullable=true)
     */
    private $totalOtroGasto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="OtroGasto",inversedBy="planEstimadosOtrosGastos")
     */
    protected $otroGasto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadosOtrosGastos")
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
     * Set totalOtroGasto
     *
     * @param integer $totalOtroGasto
     *
     * @return PlanEstimadoOtrosGastos
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
     * @return PlanEstimadoOtrosGastos
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
     * Set planEstimadoIndicadores
     *
     * @param \AppBundle\Entity\PlanEstimadoIndicadores $planEstimadoIndicadores
     *
     * @return PlanEstimadoOtrosGastos
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
     * Set aprobarPrespuestoMesOtroGasto
     *
     * @param boolean $aprobarPrespuestoMesOtroGasto
     *
     * @return PlanEstimadoOtrosGastos
     */
    public function setAprobarPrespuestoMesOtroGasto($aprobarPrespuestoMesOtroGasto)
    {
        $this->aprobarPrespuestoMesOtroGasto = $aprobarPrespuestoMesOtroGasto;

        return $this;
    }

    /**
     * Get aprobarPrespuestoMesOtroGasto
     *
     * @return boolean
     */
    public function getAprobarPrespuestoMesOtroGasto()
    {
        return $this->aprobarPrespuestoMesOtroGasto;
    }

    /**
     * Set aprobarPrespuestoDivisionMesOtroGasto
     *
     * @param boolean $aprobarPrespuestoDivisionMesOtroGasto
     *
     * @return PlanEstimadoOtrosGastos
     */
    public function setAprobarPrespuestoDivisionMesOtroGasto($aprobarPrespuestoDivisionMesOtroGasto)
    {
        $this->aprobarPrespuestoDivisionMesOtroGasto = $aprobarPrespuestoDivisionMesOtroGasto;

        return $this;
    }

    /**
     * Get aprobarPrespuestoDivisionMesOtroGasto
     *
     * @return boolean
     */
    public function getAprobarPrespuestoDivisionMesOtroGasto()
    {
        return $this->aprobarPrespuestoDivisionMesOtroGasto;
    }


    /**
     * Set aprobarPrespuestoCentroCostoMesOtroGasto
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesOtroGasto
     *
     * @return PlanEstimadoOtrosGastos
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
}
