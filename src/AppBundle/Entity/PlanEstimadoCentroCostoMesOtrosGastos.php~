<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoCentroCostoMesOtrosGastos
 *
 * @ORM\Table(name="plan_estimado_centro_costo_mes_otros_gastos",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA14", columns={"mes","otro_gasto_id","centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoCentroCostoMesOtrosGastosRepository")
 */
class PlanEstimadoCentroCostoMesOtrosGastos
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
     * @ORM\ManyToOne(targetEntity="OtroGasto",inversedBy="planEstimadosCentroCostoMesOtrosGastos")
     */
    protected $otroGasto;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadosCentroCostoMesOtrosGastos")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="CentroCosto",inversedBy="planEstimadosCentroCostoMesOtrosGastos")
     */
    protected $centroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadosCentroCostoMesOtrosGastos")
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
     * @return PlanEstimadoCentroCostoMesOtrosGastos
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
     * @return PlanEstimadoCentroCostoMesOtrosGastos
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
     * @return PlanEstimadoCentroCostoMesOtrosGastos
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
     * @return PlanEstimadoCentroCostoMesOtrosGastos
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
     * Set centroCosto
     *
     * @param \AppBundle\Entity\CentroCosto $centroCosto
     *
     * @return PlanEstimadoCentroCostoMesOtrosGastos
     */
    public function setCentroCosto(\AppBundle\Entity\CentroCosto $centroCosto = null)
    {
        $this->centroCosto = $centroCosto;

        return $this;
    }

    /**
     * Get centroCosto
     *
     * @return \AppBundle\Entity\CentroCosto
     */
    public function getCentroCosto()
    {
        return $this->centroCosto;
    }

    /**
     * Set planEstimadoIndicadores
     *
     * @param \AppBundle\Entity\PlanEstimadoIndicadores $planEstimadoIndicadores
     *
     * @return PlanEstimadoCentroCostoMesOtrosGastos
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
