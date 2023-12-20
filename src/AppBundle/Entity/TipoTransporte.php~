<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoTransporte
 *
 * @ORM\Table(name="tipo_transporte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoTransporteRepository")
 */
class TipoTransporte
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
     * @ORM\OneToMany(targetEntity="ModeloTransporte", mappedBy="tipoTransporte")
     */
    private $modelosTransportes;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->modelosTransportes = new ArrayCollection();
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
     * @return TipoTransporte
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
     * Add modelosTransporte
     *
     * @param ModeloTransporte $modelosTransporte
     *
     * @return TipoTransporte
     */
    public function addModelosTransporte(ModeloTransporte $modelosTransporte)
    {
        $this->modelosTransportes[] = $modelosTransporte;

        return $this;
    }

    /**
     * Remove modelosTransporte
     *
     * @param ModeloTransporte $modelosTransporte
     */
    public function removeModelosTransporte(ModeloTransporte $modelosTransporte)
    {
        $this->modelosTransportes->removeElement($modelosTransporte);
    }

    /**
     * Get modelosTransportes
     *
     * @return Collection
     */
    public function getModelosTransportes()
    {
        return $this->modelosTransportes;
    }
}
