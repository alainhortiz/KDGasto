<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionMesAmortizacion
 *
 * @ORM\Table(name="plan_estimado_division_mes_amortizacion",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA20", columns={"mes","division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionMesAmortizacionRepository")
 */
class PlanEstimadoDivisionMesAmortizacion
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
     * @ORM\Column(name="totalAmortizacion", type="integer",nullable=true)
     */
    private $totalAmortizacion = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoAmortizacionesDivisionMeses")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoAmortizacionesDivisionMeses")
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
     * @return PlanEstimadoDivisionMesAmortizacion
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
     * Set totalAmortizacion
     *
     * @param integer $totalAmortizacion
     *
     * @return PlanEstimadoDivisionMesAmortizacion
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
     * @return PlanEstimadoDivisionMesAmortizacion
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
     * @return PlanEstimadoDivisionMesAmortizacion
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
