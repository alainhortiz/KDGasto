<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanEstimadoCentroCostoMesLubricante
 *
 * @ORM\Table(name="plan_estimado_centro_costo_mes_lubricante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoCentroCostoMesLubricanteRepository")
 */
class PlanEstimadoCentroCostoMesLubricante
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
     * @ORM\ManyToOne(targetEntity="Transporte",inversedBy="planEstimadoCentrosCostosLubricantesMeses")
     */
    protected $medioTRansporte;

    /**
     * @var int
     *
     * @ORM\Column(name="ltsMes", type="integer",nullable=false)
     */
    private $ltsMes = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="precio", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $precio = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="importeMes", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $importeMes = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Lubricante",inversedBy="planEstimadoCentrosCostosLubricantesMeses")
     */
    protected $lubricante;

    /**
     * @ORM\ManyToOne(targetEntity="CentroCosto",inversedBy="planEstimadoCentrosCostosLubricantesMeses")
     */
    protected $centroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoCentrosCostosLubricantesMeses")
     */
    protected $planEstimadoIndicadores;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoCentrosCostosLubricantesMeses")
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
     * Set mes
     *
     * @param string $mes
     *
     * @return PlanEstimadoCentroCostoMesLubricante
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
     * Set ltsMes
     *
     * @param integer $ltsMes
     *
     * @return PlanEstimadoCentroCostoMesLubricante
     */
    public function setLtsMes($ltsMes)
    {
        $this->ltsMes = $ltsMes;

        return $this;
    }

    /**
     * Get ltsMes
     *
     * @return integer
     */
    public function getLtsMes()
    {
        return $this->ltsMes;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return PlanEstimadoCentroCostoMesLubricante
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
     * Set importeMes
     *
     * @param string $importeMes
     *
     * @return PlanEstimadoCentroCostoMesLubricante
     */
    public function setImporteMes($importeMes)
    {
        $this->importeMes = $importeMes;

        return $this;
    }

    /**
     * Get importeMes
     *
     * @return string
     */
    public function getImporteMes()
    {
        return $this->importeMes;
    }

    /**
     * Set medioTRansporte
     *
     * @param \AppBundle\Entity\Transporte $medioTRansporte
     *
     * @return PlanEstimadoCentroCostoMesLubricante
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
     * @return PlanEstimadoCentroCostoMesLubricante
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
     * @return PlanEstimadoCentroCostoMesLubricante
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
     * @return PlanEstimadoCentroCostoMesLubricante
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
     * @return PlanEstimadoCentroCostoMesLubricante
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
