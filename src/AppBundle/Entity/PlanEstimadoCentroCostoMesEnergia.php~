<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoCentroCostoMesEnergia
 *
 * @ORM\Table(name="plan_estimado_centro_costo_mes_energia",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA10", columns={"mes","centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoCentroCostoMesEnergiaRepository")
 */
class PlanEstimadoCentroCostoMesEnergia
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
     * @ORM\Column(name="totalKWCentroCostoMes", type="integer",nullable=true)
     */
    private $totalKWCentroCostoMes = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="totalEnergiaPresupuesto",  type="decimal", precision=18, scale=2, nullable=true)
     */
    private $totalEnergiaPresupuesto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoCentrosCostosEnergiaMeses")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="CentroCosto",inversedBy="planEstimadoCentrosCostosEnergiaMeses")
     */
    protected $centroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoCentrosCostosEnergiaMeses")
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
     * @return PlanEstimadoCentroCostoMesEnergia
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
     * Set totalKWCentroCostoMes
     *
     * @param integer $totalKWCentroCostoMes
     *
     * @return PlanEstimadoCentroCostoMesEnergia
     */
    public function setTotalKWCentroCostoMes($totalKWCentroCostoMes)
    {
        $this->totalKWCentroCostoMes = $totalKWCentroCostoMes;

        return $this;
    }

    /**
     * Get totalKWCentroCostoMes
     *
     * @return integer
     */
    public function getTotalKWCentroCostoMes()
    {
        return $this->totalKWCentroCostoMes;
    }

    /**
     * Set totalEnergiaPresupuesto
     *
     * @param string $totalEnergiaPresupuesto
     *
     * @return PlanEstimadoCentroCostoMesEnergia
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
     * @return PlanEstimadoCentroCostoMesEnergia
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
     * @return PlanEstimadoCentroCostoMesEnergia
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
     * @return PlanEstimadoCentroCostoMesEnergia
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
