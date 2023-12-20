<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * PlanEstimadoMesOtrosGastos
 *
 * @ORM\Table(name="plan_estimado_mes_otros_gastos",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA12", columns={"mes","otro_gasto_id", "plan_estimado_indicadores_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanEstimadoMesOtrosGastosRepository")
 */
class PlanEstimadoMesOtrosGastos
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
     * @ORM\Column(name="totalOtroGasto", type="integer",nullable=true)
     */
    private $totalOtroGasto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="OtroGasto",inversedBy="planEstimadosMesOtrosGastos")
     */
    protected $otroGasto;

    /**
     * @ORM\ManyToOne(targetEntity="PlanEstimadoIndicadores",inversedBy="planEstimadosMesOtrosGastos")
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
     * @return PlanEstimadoMesOtrosGastos
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
     * Set totalOtroGasto
     *
     * @param integer $totalOtroGasto
     *
     * @return PlanEstimadoMesOtrosGastos
     */
    public function setTotalOtroGasto($totalOtroGasto)
    {
        $this->totalOtroGasto = $totalOtroGasto;

        return $this;
    }

    /**
     * Get totalOtroGasto
     *
     * @return integer
     */
    public function getTotalOtroGasto()
    {
        return $this->totalOtroGasto;
    }

    /**
     * Set otroGasto
     *
     * @param \AppBundle\Entity\OtroGasto $otroGasto
     *
     * @return PlanEstimadoMesOtrosGastos
     */
    public function setOtroGasto(\AppBundle\Entity\OtroGasto $otroGasto = null)
    {
        $this->otroGasto = $otroGasto;

        return $this;
    }

    /**
     * Get otroGasto
     *
     * @return \AppBundle\Entity\OtroGasto
     */
    public function getOtroGasto()
    {
        return $this->otroGasto;
    }

    /**
     * Set planEstimadoIndicadores
     *
     * @param \AppBundle\Entity\PlanEstimadoIndicadores $planEstimadoIndicadores
     *
     * @return PlanEstimadoMesOtrosGastos
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
