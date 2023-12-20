<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanEstimadoCentroCostoLubricante
 *
 * @ORM\Table(name="plan_estimado_centro_costo_lubricante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoCentroCostoLubricanteRepository")
 */
class PlanEstimadoCentroCostoLubricante
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
     * @ORM\Column(name="aprobarPrespuestoCentroCostoMesLubricante", type="boolean")
     */
    private $aprobarPrespuestoCentroCostoMesLubricante = false;

    /**
     * @ORM\ManyToOne(targetEntity="Transporte",inversedBy="planEstimadoCentrosCostosLubricantes")
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
     * @ORM\ManyToOne(targetEntity="Lubricante",inversedBy="planEstimadoCentrosCostosLubricantes")
     */
    protected $lubricante;

    /**
     * @ORM\ManyToOne(targetEntity="CentroCosto",inversedBy="planEstimadoCentrosCostosLubricantes")
     */
    protected $centroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoCentrosCostosLubricantes")
     */
    protected $planEstimadoIndicadores;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoCentrosCostosLubricantes")
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
     * Set aprobarPrespuestoCentroCostoMesLubricante
     *
     * @param boolean $aprobarPrespuestoCentroCostoMesLubricante
     *
     * @return PlanEstimadoCentroCostoLubricante
     */
    public function setAprobarPrespuestoCentroCostoMesLubricante($aprobarPrespuestoCentroCostoMesLubricante)
    {
        $this->aprobarPrespuestoCentroCostoMesLubricante = $aprobarPrespuestoCentroCostoMesLubricante;

        return $this;
    }

    /**
     * Get aprobarPrespuestoCentroCostoMesLubricante
     *
     * @return boolean
     */
    public function getAprobarPrespuestoCentroCostoMesLubricante()
    {
        return $this->aprobarPrespuestoCentroCostoMesLubricante;
    }

    /**
     * Set lts
     *
     * @param integer $lts
     *
     * @return PlanEstimadoCentroCostoLubricante
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
     * @return PlanEstimadoCentroCostoLubricante
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
     * @return PlanEstimadoCentroCostoLubricante
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
     * @return PlanEstimadoCentroCostoLubricante
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
     * Set lubricante
     *
     * @param \AppBundle\Entity\Lubricante $lubricante
     *
     * @return PlanEstimadoCentroCostoLubricante
     */
    public function setLubricante(\AppBundle\Entity\Lubricante $lubricante = null)
    {
        $this->lubricante = $lubricante;

        return $this;
    }

    /**
     * Get lubricante
     *
     * @return \AppBundle\Entity\Lubricante
     */
    public function getLubricante()
    {
        return $this->lubricante;
    }

    /**
     * Set centroCosto
     *
     * @param \AppBundle\Entity\CentroCosto $centroCosto
     *
     * @return PlanEstimadoCentroCostoLubricante
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
     * @return PlanEstimadoCentroCostoLubricante
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
     * @return PlanEstimadoCentroCostoLubricante
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
