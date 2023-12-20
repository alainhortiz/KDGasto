<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionMesOtrosGastos
 *
 * @ORM\Table(name="plan_estimado_division_mes_otros_gastos",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA13", columns={"mes","otro_gasto_id","division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionMesOtrosGastosRepository")
 */
class PlanEstimadoDivisionMesOtrosGastos
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
     * @ORM\Column(name="mes", type="string", length=10)
     */
    private $mes;

    /**
     * @var int
     *
     * @ORM\Column(name="totalOtroGasto", type="integer",nullable=true)
     */
    private $totalOtroGasto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="OtroGasto",inversedBy="planEstimadosDivisionMesOtrosGastos")
     */
    protected $otroGasto;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadosDivisionMesOtrosGastos")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadosDivisionMesOtrosGastos")
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
     * Set mes
     *
     * @param string $mes
     *
     * @return PlanEstimadoDivisionMesOtrosGastos
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return string
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set totalOtroGasto
     *
     * @param integer $totalOtroGasto
     *
     * @return PlanEstimadoDivisionMesOtrosGastos
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
     * @return PlanEstimadoDivisionMesOtrosGastos
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
     * @return PlanEstimadoDivisionMesOtrosGastos
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
     * @return PlanEstimadoDivisionMesOtrosGastos
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
