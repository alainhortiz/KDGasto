<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanEstimadoDivisionMes
 *
 * @ORM\Table(name="plan_estimado_division_mes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionMesRepository")
 */
class PlanEstimadoDivisionMes
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
     * @ORM\Column(name="totalVentaDivisionMes", type="integer",nullable=true)
     */
    private $totalVentaDivisionMes = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoDivisionesMeses")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoDivisionesMeses")
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
     * @return PlanEstimadoDivisionMes
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
     * Set totalVentaDivisionMes
     *
     * @param integer $totalVentaDivisionMes
     *
     * @return PlanEstimadoDivisionMes
     */
    public function setTotalVentaDivisionMes($totalVentaDivisionMes)
    {
        $this->totalVentaDivisionMes = $totalVentaDivisionMes;

        return $this;
    }

    /**
     * Get totalVentaDivisionMes
     *
     * @return integer
     */
    public function getTotalVentaDivisionMes()
    {
        return $this->totalVentaDivisionMes;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionMes
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
     * Set planEstimadoIndicadores
     *
     * @param PlanEstimadoIndicadores $planEstimadoIndicadores
     *
     * @return PlanEstimadoDivisionMes
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
