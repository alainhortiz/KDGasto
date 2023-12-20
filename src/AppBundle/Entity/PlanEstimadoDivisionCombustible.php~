<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoDivisionCombustible
 *
 * @ORM\Table(name="plan_estimado_division_combustible",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA05", columns={"tipo_combustible_id", "division_centro_costo_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionCombustibleRepository")
 */
class PlanEstimadoDivisionCombustible
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
     * @ORM\Column(name="aprobarPrespuestoDivisionMesCombustible", type="boolean")
     */
    private $aprobarPrespuestoDivisionMesCombustible = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoCentroCostoCombustible", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoCombustible = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesCombustible", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesCombustible = false;

    /**
     * @var int
     *
     * @ORM\Column(name="lts", type="integer",nullable=false)
     */
    private $lts = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="precio", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $precio = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="importe", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $importe = 0;

    /**
     * @ORM\ManyToOne(targetEntity="TipoCombustible",inversedBy="planEstimadoCombustibles")
     */
    protected $tipoCombustible;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoCombustibles")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoCombustibles")
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
     * Set aprobarPrespuestoDivisionMesCombustible
     *
     * @param boolean $aprobarPrespuestoDivisionMesCombustible
     *
     * @return PlanEstimadoDivisionCombustible
     */
    public function setAprobarPrespuestoDivisionMesCombustible($aprobarPrespuestoDivisionMesCombustible)
    {
        $this->aprobarPrespuestoDivisionMesCombustible = $aprobarPrespuestoDivisionMesCombustible;

        return $this;
    }

    /**
     * Get aprobarPrespuestoDivisionMesCombustible
     *
     * @return boolean
     */
    public function getAprobarPrespuestoDivisionMesCombustible()
    {
        return $this->aprobarPrespuestoDivisionMesCombustible;
    }

    /**
     * Set aprobarPrespuestoCentroCostoCombustible
     *
     * @param boolean $aprobarPrespuestoCentroCostoCombustible
     *
     * @return PlanEstimadoDivisionCombustible
     */
    public function setAprobarPrespuestoCentroCostoCombustible($aprobarPrespuestoCentroCostoCombustible)
    {
        $this->aprobarPrespuestoCentroCostoCombustible = $aprobarPrespuestoCentroCostoCombustible;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoCombustible
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoCombustible()
    {
        return $this->aprobarPrespuestoCentroCostoCombustible;
    }

    /**
     * Set aprobarPrespuestoCentroCostoMesCombustible
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesCombustible
     *
     * @return PlanEstimadoDivisionCombustible
     */
    public function setAprobarPrespuestoCentroCostoMesCombustible($aprobarPrespuestoCentroCostoMesCombustible)
    {
        $this->aprobarPrespuestoCentroCostoMesCombustible = $aprobarPrespuestoCentroCostoMesCombustible;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoMesCombustible
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoMesCombustible()
    {
        return $this->aprobarPrespuestoCentroCostoMesCombustible;
    }

    /**
     * Set lts
     *
     * @param integer $lts
     *
     * @return PlanEstimadoDivisionCombustible
     */
    public function setLts($lts)
    {
        $this->lts = $lts;

        return $this;
    }

    /**
     * Get lts
     *
     * @return integer
     */
    public function getLts()
    {
        return $this->lts;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return PlanEstimadoDivisionCombustible
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return PlanEstimadoDivisionCombustible
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set tipoCombustible
     *
     * @param \AppBundle\Entity\TipoCombustible $tipoCombustible
     *
     * @return PlanEstimadoDivisionCombustible
     */
    public function setTipoCombustible(\AppBundle\Entity\TipoCombustible $tipoCombustible = null)
    {
        $this->tipoCombustible = $tipoCombustible;

        return $this;
    }

    /**
     * Get tipoCombustible
     *
     * @return \AppBundle\Entity\TipoCombustible
     */
    public function getTipoCombustible()
    {
        return $this->tipoCombustible;
    }

    /**
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionCombustible
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
     * @return PlanEstimadoDivisionCombustible
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
