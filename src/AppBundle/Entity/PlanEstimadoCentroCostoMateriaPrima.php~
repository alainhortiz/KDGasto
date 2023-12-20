<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoCentroCostoMateriaPrima
 *
 * @ORM\Table(name="plan_estimado_centro_costo_materia_prima",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA16", columns={"centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoCentroCostoMateriaPrimaRepository")
 */
class PlanEstimadoCentroCostoMateriaPrima
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
     * @var int
     *
     * @ORM\Column(name="totalMateriaPrima", type="integer",nullable=true)
     */
    private $totalMateriaPrima = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoMateriasPrimasCentroCosto")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="CentroCosto",inversedBy="planEstimadoMateriasPrimasCentroCosto")
     */
    protected $centroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoMateriasPrimasCentroCosto")
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
     * Set totalMateriaPrima
     *
     * @param integer $totalMateriaPrima
     *
     * @return PlanEstimadoCentroCostoMateriaPrima
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
     * @return PlanEstimadoCentroCostoMateriaPrima
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
     * @return PlanEstimadoCentroCostoMateriaPrima
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
     * Set centroCosto
     *
     * @param \AppBundle\Entity\CentroCosto $centroCosto
     *
     * @return PlanEstimadoCentroCostoMateriaPrima
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
}
