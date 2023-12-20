<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanEstimadoDivisionMesLubricante
 *
 * @ORM\Table(name="plan_estimado_division_mes_lubricante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoDivisionMesLubricanteRepository")
 */
class PlanEstimadoDivisionMesLubricante
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
     * @ORM\ManyToOne(targetEntity="Lubricante",inversedBy="planEstimadoLubricanteMeses")
     */
    protected $lubricante;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionCentroCosto",inversedBy="planEstimadoLubricanteMeses")
     */
    protected $divisionCentroCosto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadoLubricanteMeses")
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
     * @return PlanEstimadoDivisionMesLubricante
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
     * @return PlanEstimadoDivisionMesLubricante
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
     * @return PlanEstimadoDivisionMesLubricante
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
     * @return PlanEstimadoDivisionMesLubricante
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
     * Set lubricante
     *
     * @param \AppBundle\Entity\Lubricante $lubricante
     *
     * @return PlanEstimadoDivisionMesLubricante
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
     * Set divisionCentroCosto
     *
     * @param \AppBundle\Entity\DivisionCentroCosto $divisionCentroCosto
     *
     * @return PlanEstimadoDivisionMesLubricante
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
     * @return PlanEstimadoDivisionMesLubricante
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
