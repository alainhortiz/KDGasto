<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanEstimadoDivisionMesCombustible
 *
 * @ORM\Table(name="plan_estimado_division_mes_combustible")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionMesCombustibleRepository")
 */
class PlanEstimadoDivisionMesCombustible
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
     * @ORM\ManyToOne(targetEntity="TipoCombustible",inversedBy="planEstimadoCombustibleMeses")
     */
    protected $tipoCombustible;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoCombustibleMeses")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoCombustibleMeses")
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
     * @return PlanEstimadoDivisionMesCombustible
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
     * @return PlanEstimadoDivisionMesCombustible
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
     * @return PlanEstimadoDivisionMesCombustible
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
     * @return PlanEstimadoDivisionMesCombustible
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
     * Set tipoCombustible
     *
     * @param \AppBundle\Entity\TipoCombustible $tipoCombustible
     *
     * @return PlanEstimadoDivisionMesCombustible
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
     * @return PlanEstimadoDivisionMesCombustible
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
     * @return PlanEstimadoDivisionMesCombustible
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
