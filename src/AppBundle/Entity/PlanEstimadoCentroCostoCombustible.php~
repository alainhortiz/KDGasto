<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanEstimadoCentroCostoCombustible
 *
 * @ORM\Table(name="plan_estimado_centro_costo_combustible")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoCentroCostoCombustibleRepository")
 */
class PlanEstimadoCentroCostoCombustible
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
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesCombustible", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesCombustible = false;

    /**
     * @ORM\ManyToOne(targetEntity="Transporte",inversedBy="planEstimadoCentrosCostosCombustibles")
     */
    protected $medioTRansporte;

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
     * @ORM\ManyToOne(targetEntity="TipoCombustible",inversedBy="planEstimadoCentrosCostosCombustibles")
     */
    protected $tipoCombustible;

    /**
     * @ORM\ManyToOne(targetEntity="CentroCosto",inversedBy="planEstimadoCentrosCostosCombustibles")
     */
    protected $centroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoCentrosCostosCombustibles")
     */
    protected $planEstimadoIndicadores;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoCentrosCostosCombustibles")
     */
    protected $divisionCentroCosto;


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
     * Set aprobarPrespuestoCentroCostoMesCombustible
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesCombustible
     *
     * @return PlanEstimadoCentroCostoCombustible
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
     * @return PlanEstimadoCentroCostoCombustible
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
     * @return PlanEstimadoCentroCostoCombustible
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
     * @return PlanEstimadoCentroCostoCombustible
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
     * Set medioTRansporte
     *
     * @param \AppBundle\Entity\Transporte $medioTRansporte
     *
     * @return PlanEstimadoCentroCostoCombustible
     */
    public function setMedioTRansporte(\AppBundle\Entity\Transporte $medioTRansporte = null)
    {
        $this->medioTRansporte = $medioTRansporte;

        return $this;
    }

    /**
     * Get medioTRansporte
     *
     * @return \AppBundle\Entity\Transporte
     */
    public function getMedioTRansporte()
    {
        return $this->medioTRansporte;
    }

    /**
     * Set tipoCombustible
     *
     * @param \AppBundle\Entity\TipoCombustible $tipoCombustible
     *
     * @return PlanEstimadoCentroCostoCombustible
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
     * Set centroCosto
     *
     * @param \AppBundle\Entity\CentroCosto $centroCosto
     *
     * @return PlanEstimadoCentroCostoCombustible
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
     * @return PlanEstimadoCentroCostoCombustible
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
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoCentroCostoCombustible
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
}
