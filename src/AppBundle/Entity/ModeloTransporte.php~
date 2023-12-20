<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModeloTransporte
 *
 * @ORM\Table(name="modelo_transporte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModeloTransporteRepository")
 */
class ModeloTransporte
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
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="TipoTransporte",inversedBy="modeloTransporte")
     */
    protected $tipoTransporte;

    /**
     * @ORM\OneToMany(targetEntity="Transporte", mappedBy="modeloTransporte")
     */
    private $transportes;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->transportes = new ArrayCollection();
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
     * @return ModeloTransporte
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
     * Add transporte
     *
     * @param Transporte $transporte
     *
     * @return ModeloTransporte
     */
    public function addTransporte(Transporte $transporte)
    {
        $this->transportes[] = $transporte;

        return $this;
    }

    /**
     * Remove transporte
     *
     * @param Transporte $transporte
     */
    public function removeTransporte(Transporte $transporte)
    {
        $this->transportes->removeElement($transporte);
    }

    /**
     * Get transportes
     *
     * @return Collection
     */
    public function getTransportes()
    {
        return $this->transportes;
    }


    /**
     * Set tipoTransporte
     *
     * @param TipoTransporte $tipoTransporte
     *
     * @return ModeloTransporte
     */
    public function setTipoTransporte(TipoTransporte $tipoTransporte = null)
    {
        $this->tipoTransporte = $tipoTransporte;

        return $this;
    }

    /**
     * Get tipoTransporte
     *
     * @return TipoTransporte
     */
    public function getTipoTransporte()
    {
        return $this->tipoTransporte;
    }
}
