<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionMateriaPrima
 *
 * @ORM\Table(name="plan_estimado_division_materia_prima",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA12", columns={"division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionMateriaPrimaRepository")
 */
class PlanEstimadoDivisionMateriaPrima
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
     * @ORM\Column(name="aprobadoPlanMateriaPrimaCentroCosto", type="boolean")
     */
    private $aprobadoPlanMateriaPrimaCentroCosto = false;

    /**
     * @var int
     *
     * @ORM\Column(name="totalMateriaPrima", type="integer",nullable=true)
     */
    private $totalMateriaPrima = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoMateriasPrimasDivision")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoMateriasPrimasDivision")
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
     * Set aprobadoPlanMateriaPrimaCentroCosto
     *
     * @param boolean $aprobadoPlanMateriaPrimaCentroCosto
     *
     * @return PlanEstimadoDivisionMateriaPrima
     */
    public function setAprobadoPlanMateriaPrimaCentroCosto($aprobadoPlanMateriaPrimaCentroCosto)
    {
        $this->aprobadoPlanMateriaPrimaCentroCosto = $aprobadoPlanMateriaPrimaCentroCosto;

        return $this;
    }

    /**
     * Get aprobadoPlanMateriaPrimaCentroCosto
     *
     * @return boolean
     */
    public function getAprobadoPlanMateriaPrimaCentroCosto()
    {
        return $this->aprobadoPlanMateriaPrimaCentroCosto;
    }

    /**
     * Set totalMateriaPrima
     *
     * @param integer $totalMateriaPrima
     *
     * @return PlanEstimadoDivisionMateriaPrima
     */
    public function setTotalMateriaPrima($totalMateriaPrima)
    {
        $this->totalMateriaPrima = $totalMateriaPrima;

        return $this;
    }

    /**
     * Get totalMateriaPrima
     *
     * @return integer
     */
    public function getTotalMateriaPrima()
    {
        return $this->totalMateriaPrima;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionMateriaPrima
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
     * @return PlanEstimadoDivisionMateriaPrima
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
