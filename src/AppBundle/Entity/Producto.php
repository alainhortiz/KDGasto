<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
 */
class Producto
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
     * @ORM\Column(name="nombre", type="string", length=150)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="FichaCosto" ,mappedBy="fichaCosto" , cascade={"remove"})
     *
     */
    private $fichaCosto;

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
     * @return Producto
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
     * Set fichaCosto
     *
     * @param \AppBundle\Entity\FichaCosto $fichaCosto
     *
     * @return Producto
     */
    public function setFichaCosto(\AppBundle\Entity\FichaCosto $fichaCosto = null)
    {
        $this->fichaCosto = $fichaCosto;

        return $this;
    }

    /**
     * Get fichaCosto
     *
     * @return \AppBundle\Entity\FichaCosto
     */
    public function getFichaCosto()
    {
        return $this->fichaCosto;
    }
}
