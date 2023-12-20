<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoPlantillaCargo
 *
 * @ORM\Table(name="tipo_plantilla_cargo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoPlantillaCargoRepository")
 */
class TipoPlantillaCargo
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
     * @ORM\Column(name="nombre", type="string", length=150, unique=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="PlantillaCargo", mappedBy="tipoPlantilla")
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoPlantillaCargo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add plantillasCargo
     *
     * @param \AppBundle\Entity\PlantillaCargo $plantillasCargo
     *
     * @return TipoPlantillaCargo
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
}
