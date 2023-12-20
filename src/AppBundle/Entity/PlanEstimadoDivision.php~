<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivision
 *
 * @ORM\Table(name="plan_estimado_division",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA01", columns={"division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionRepository")
 */
class PlanEstimadoDivision
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
     * @ORM\Column(name="aprobadoPlanVentasMensualDivision", type="boolean")
     */
    private $aprobadoPlanVentasMensualDivision = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobadoPlanVentasMensualCentroCosto", type="boolean")
     */
    private $aprobadoPlanVentasMensualCentroCosto = false;

    /**
     * @var int
     *
     * @ORM\Column(name="totalVentaDivision", type="integer",nullable=true)
     */
    private $totalVentaDivision = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoDivisiones")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoDivisiones")
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
     * Set totalVentaDivision
     *
     * @param integer $totalVentaDivision
     *
     * @return PlanEstimadoDivision
     */
    public function setTotalVentaDivision($totalVentaDivision)
    {
        $this->totalVentaDivision = $totalVentaDivision;

        return $this;
    }

    /**
     * Get totalVentaDivision
     *
     * @return integer
     */
    public function getTotalVentaDivision()
    {
        return $this->totalVentaDivision;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivision
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
     * @return PlanEstimadoDivision
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


    /**
     * Set aprobadoPlanVentasMensualDivision
     *
     * @param boolean $aprobadoPlanVentasMensualDivision
     *
     * @return PlanEstimadoDivision
     */
    public function setAprobadoPlanVentasMensualDivision($aprobadoPlanVentasMensualDivision)
    {
        $this->aprobadoPlanVentasMensualDivision = $aprobadoPlanVentasMensualDivision;

        return $this;
    }

    /**
     * Get aprobadoPlanVentasMensualDivision
     *
     * @return boolean
     */
    public function getAprobadoPlanVentasMensualDivision()
    {
        return $this->aprobadoPlanVentasMensualDivision;
    }

    /**
     * Set aprobadoPlanVentasMensualCentroCosto
     *
     * @param boolean $aprobadoPlanVentasMensualCentroCosto
     *
     * @return PlanEstimadoDivision
     */
    public function setAprobadoPlanVentasMensualCentroCosto($aprobadoPlanVentasMensualCentroCosto)
    {
        $this->aprobadoPlanVentasMensualCentroCosto = $aprobadoPlanVentasMensualCentroCosto;

        return $this;
    }

    /**
     * Get aprobadoPlanVentasMensualCentroCosto
     *
     * @return boolean
     */
    public function getAprobadoPlanVentasMensualCentroCosto()
    {
        return $this->aprobadoPlanVentasMensualCentroCosto;
    }
}
