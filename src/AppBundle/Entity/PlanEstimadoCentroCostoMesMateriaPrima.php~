<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoCentroCostoMesMateriaPrima
 *
 * @ORM\Table(name="plan_estimado_centro_costo_mes_materia_prima",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA14", columns={"mes","centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoCentroCostoMesMateriaPrimaRepository")
 */
class PlanEstimadoCentroCostoMesMateriaPrima
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
     * @ORM\Column(name="coeficiente", type="decimal", precision=18, scale=3, nullable=false)
     */
    private $coeficiente = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="totalMateriaPrima", type="integer",nullable=true)
     */
    private $totalMateriaPrima = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoMateriasPrimasCentroCostoMeses")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="CentroCosto",inversedBy="planEstimadoMateriasPrimasCentroCostoMeses")
     */
    protected $centroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoMateriasPrimasCentroCostoMeses")
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
     * @return PlanEstimadoCentroCostoMesMateriaPrima
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
     * Set coeficiente
     *
     * @param string $coeficiente
     *
     * @return PlanEstimadoCentroCostoMesMateriaPrima
     */
    public function setCoeficiente($coeficiente)
    {
        $this->coeficiente = $coeficiente;

        return $this;
    }

    /**
     * Get coeficiente
     *
     * @return string
     */
    public function getCoeficiente()
    {
        return $this->coeficiente;
    }

    /**
     * Set totalMateriaPrima
     *
     * @param integer $totalMateriaPrima
     *
     * @return PlanEstimadoCentroCostoMesMateriaPrima
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
     * @return PlanEstimadoCentroCostoMesMateriaPrima
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
     * @return PlanEstimadoCentroCostoMesMateriaPrima
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
     * @return PlanEstimadoCentroCostoMesMateriaPrima
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
