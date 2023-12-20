<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModalidadPago
 *
 * @ORM\Table(name="modalidad_pago")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModalidadPagoRepository")
 */
class ModalidadPago
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
     * @ORM\OneToMany(targetEntity="VentaProducto", mappedBy="modalidad")
     */
    private $ventasProductos;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->ventasProductos = new ArrayCollection();
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
     * @return ModalidadPago
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
     * Add ventasProducto
     *
     * @param \AppBundle\Entity\VentaProducto $ventasProducto
     *
     * @return ModalidadPago
     */
    public function addVentasProducto(\AppBundle\Entity\VentaProducto $ventasProducto)
    {
        $this->ventasProductos[] = $ventasProducto;

        return $this;
    }

    /**
     * Remove ventasProducto
     *
     * @param \AppBundle\Entity\VentaProducto $ventasProducto
     */
    public function removeVentasProducto(\AppBundle\Entity\VentaProducto $ventasProducto)
    {
        $this->ventasProductos->removeElement($ventasProducto);
    }

    /**
     * Get ventasProductos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentasProductos()
    {
        return $this->ventasProductos;
    }
}
