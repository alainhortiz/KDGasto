<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanEstimadoDivisionMesEnergia
 *
 * @ORM\Table(name="plan_estimado_division_mes_energia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionMesEnergiaRepository")
 */
class PlanEstimadoDivisionMesEnergia
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
     * @ORM\Column(name="totalKWDivisionMes", type="integer",nullable=true)
     */
    private $totalKWDivisionMes = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="totalEnergiaPresupuesto",  type="decimal", precision=18, scale=2, nullable=true)
     */
    private $totalEnergiaPresupuesto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoEnergiasMeses")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoEnergiasMeses")
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
     * @return PlanEstimadoDivisionMesEnergia
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
     * Set totalKWDivisionMes
     *
     * @param integer $totalKWDivisionMes
     *
     * @return PlanEstimadoDivisionMesEnergia
     */
    public function setTotalKWDivisionMes($totalKWDivisionMes)
    {
        $this->totalKWDivisionMes = $totalKWDivisionMes;

        return $this;
    }

    /**
     * Get totalKWDivisionMes
     *
     * @return integer
     */
    public function getTotalKWDivisionMes()
    {
        return $this->totalKWDivisionMes;
    }

    /**
     * Set totalEnergiaPresupuesto
     *
     * @param string $totalEnergiaPresupuesto
     *
     * @return PlanEstimadoDivisionMesEnergia
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
     * @return PlanEstimadoDivisionMesEnergia
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
     * @return PlanEstimadoDivisionMesEnergia
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
