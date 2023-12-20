<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DenominadorCargo
 *
 * @ORM\Table(name="denominador_cargo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DenominadorCargoRepository")
 */
class DenominadorCargo
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
     * @ORM\Column(name="codigo", type="integer", unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="denominadorCargo", type="string", length=150, unique=true, nullable=false)
     */
    private $denominadorCargo;

    /**
     * @var string
     *
     * @ORM\Column(name="grupoEscala", type="string", length=10, nullable=false)
     */
    private $grupoEscala;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=1, nullable=false)
     */
    private $categoria;

    /**
     * @var int
     *
     * @ORM\Column(name="salario", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $salario = 0;

    /**
     * @ORM\OneToMany(targetEntity="PlantillaCargo", mappedBy="denominadorCargo")
     */
    private $plantillasCargos;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->plantillasCargos = new ArrayCollection();
    }

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
     * Set denominadorCargo
     *
     * @param string $denominadorCargo
     *
     * @return DenominadorCargo
     */
    public function setDenominadorCargo($denominadorCargo)
    {
        $this->denominadorCargo = $denominadorCargo;

        return $this;
    }

    /**
     * Get denominadorCargo
     *
     * @return string
     */
    public function getDenominadorCargo()
    {
        return $this->denominadorCargo;
    }

    /**
     * Set grupoEscala
     *
     * @param string $grupoEscala
     *
     * @return DenominadorCargo
     */
    public function setGrupoEscala($grupoEscala)
    {
        $this->grupoEscala = $grupoEscala;

        return $this;
    }

    /**
     * Get grupoEscala
     *
     * @return string
     */
    public function getGrupoEscala()
    {
        return $this->grupoEscala;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     *
     * @return DenominadorCargo
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add plantillasCargo
     *
     * @param \AppBundle\Entity\PlantillaCargo $plantillasCargo
     *
     * @return DenominadorCargo
     */
    public function addPlantillasCargo(\AppBundle\Entity\PlantillaCargo $plantillasCargo)
    {
        $this->plantillasCargos[] = $plantillasCargo;

        return $this;
    }

    /**
     * Remove plantillasCargo
     *
     * @param \AppBundle\Entity\PlantillaCargo $plantillasCargo
     */
    public function removePlantillasCargo(\AppBundle\Entity\PlantillaCargo $plantillasCargo)
    {
        $this->plantillasCargos->removeElement($plantillasCargo);
    }

    /**
     * Get plantillasCargos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlantillasCargos()
    {
        return $this->plantillasCargos;
    }

    /**
     * Set salario
     *
     * @param string $salario
     *
     * @return DenominadorCargo
     */
    public function setSalario($salario)
    {
        $this->salario = $salario;

        return $this;
    }

    /**
     * Get salario
     *
     * @return string
     */
    public function getSalario()
    {
        return $this->salario;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return DenominadorCargo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
}
