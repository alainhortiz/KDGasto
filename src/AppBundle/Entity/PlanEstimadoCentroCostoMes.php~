<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoCentroCostoMes
 *
 * @ORM\Table(name="plan_estimado_centro_costo_mes",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA07", columns={"mes","centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoCentroCostoMesRepository")
 */
class PlanEstimadoCentroCostoMes
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
     * @ORM\Column(name="totalVentaCentroCostoMes", type="integer",nullable=true)
     */
    private $totalVentaCentroCostoMes = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoCentrosCostosMeses")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="CentroCosto",inversedBy="planEstimadoCentrosCostosMeses")
     */
    protected $centroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoCentrosCostosMeses")
     */
    protected $planEstimadoIndicadores;

    /**
     * Get id
     *
     * @return integer
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
     * @return PlanEstimadoCentroCostoMes
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
     * Set totalVentaCentroCostoMes
     *
     * @param integer $totalVentaCentroCostoMes
     *
     * @return PlanEstimadoCentroCostoMes
     */
    public function setTotalVentaCentroCostoMes($totalVentaCentroCostoMes)
    {
        $this->totalVentaCentroCostoMes = $totalVentaCentroCostoMes;

        return $this;
    }

    /**
     * Get totalVentaCentroCostoMes
     *
     * @return integer
     */
    public function getTotalVentaCentroCostoMes()
    {
        return $this->totalVentaCentroCostoMes;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoCentroCostoMes
     */
    public function setDivisionCentroCosto(DivisionCentroCosto $divisionCentroCosto = null)
    {
        $this->divisionCentroCosto = $divisionCentroCosto;

        return $this;
    }

    /**
     * Get divisionCentroCosto
     *
     * @return DivisionCentroCosto
     */
    public function getDivisionCentroCosto()
    {
        return $this->divisionCentroCosto;
    }

    /**
     * Set centroCosto
     *
     * @param CentroCosto $centroCosto
     *
     * @return PlanEstimadoCentroCostoMes
     */
    public function setCentroCosto(CentroCosto $centroCosto = null)
    {
        $this->centroCosto = $centroCosto;

        return $this;
    }

    /**
     * Get centroCosto
     *
     * @return CentroCosto
     */
    public function getCentroCosto()
    {
        return $this->centroCosto;
    }

    /**
     * Set planEstimadoIndicadores
     *
     * @param PlanEstimadoIndicadores $planEstimadoIndicadores
     *
     * @return PlanEstimadoCentroCostoMes
     */
    public function setPlanEstimadoIndicadores(PlanEstimadoIndicadores $planEstimadoIndicadores = null)
    {
        $this->planEstimadoIndicadores = $planEstimadoIndicadores;

        return $this;
    }

    /**
     * Get planEstimadoIndicadores
     *
     * @return PlanEstimadoIndicadores
     */
    public function getPlanEstimadoIndicadores()
    {
        return $this->planEstimadoIndicadores;
    }
}
