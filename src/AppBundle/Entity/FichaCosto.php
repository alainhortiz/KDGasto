<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * FichaCosto
 *
 * @ORM\Table(name="ficha_costo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FichaCostoRepository")
 */
class FichaCosto
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
     * @ORM\Column(name="precioCosto", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $precioCosto = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="precioVenta", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $precioVenta = 0;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaCreada", type="date", nullable=true)
     */
    private $fechaCreada;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaModificada", type="date", nullable=true)
     */
    private $fechaModificada;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="Producto" ,inversedBy="fichaCosto")
     * @ORM\JoinColumn(name="producto_id" , referencedColumnName="id")
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="ConceptoGasto",inversedBy="fichasCostos")
     */
    protected $conceptoGasto;

    /**
     * @ORM\ManyToOne(targetEntity="VentaProducto",inversedBy="fichasCostos")
     */
    protected $ventaProducto;

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
     * Set precioCosto
     *
     * @param string $precioCosto
     *
     * @return FichaCosto
     */
    public function setPrecioCosto($precioCosto)
    {
        $this->precioCosto = $precioCosto;

        return $this;
    }

    /**
     * Get precioCosto
     *
     * @return string
     */
    public function getPrecioCosto()
    {
        return $this->precioCosto;
    }

    /**
     * Set precioVenta
     *
     * @param string $precioVenta
     *
     * @return FichaCosto
     */
    public function setPrecioVenta($precioVenta)
    {
        $this->precioVenta = $precioVenta;

        return $this;
    }

    /**
     * Get precioVenta
     *
     * @return string
     */
    public function getPrecioVenta()
    {
        return $this->precioVenta;
    }

    /**
     * Set fechaCreada
     *
     * @param \DateTime $fechaCreada
     *
     * @return FichaCosto
     */
    public function setFechaCreada($fechaCreada)
    {
        $this->fechaCreada = $fechaCreada;

        return $this;
    }

    /**
     * Get fechaCreada
     *
     * @return \DateTime
     */
    public function getFechaCreada()
    {
        return $this->fechaCreada;
    }

    /**
     * Set fechaModificada
     *
     * @param \DateTime $fechaModificada
     *
     * @return FichaCosto
     */
    public function setFechaModificada($fechaModificada)
    {
        $this->fechaModificada = $fechaModificada;

        return $this;
    }

    /**
     * Get fechaModificada
     *
     * @return \DateTime
     */
    public function getFechaModificada()
    {
        return $this->fechaModificada;
    }

    /**
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return FichaCosto
     */
    public function setProducto(\AppBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \AppBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set conceptoGasto
     *
     * @param \AppBundle\Entity\ConceptoGasto $conceptoGasto
     *
     * @return FichaCosto
     */
    public function setConceptoGasto(\AppBundle\Entity\ConceptoGasto $conceptoGasto = null)
    {
        $this->conceptoGasto = $conceptoGasto;

        return $this;
    }

    /**
     * Get conceptoGasto
     *
     * @return \AppBundle\Entity\ConceptoGasto
     */
    public function getConceptoGasto()
    {
        return $this->conceptoGasto;
    }

    /**
     * Set ventaProducto
     *
     * @param \AppBundle\Entity\VentaProducto $ventaProducto
     *
     * @return FichaCosto
     */
    public function setVentaProducto(\AppBundle\Entity\VentaProducto $ventaProducto = null)
    {
        $this->ventaProducto = $ventaProducto;

        return $this;
    }

    /**
     * Get ventaProducto
     *
     * @return \AppBundle\Entity\VentaProducto
     */
    public function getVentaProducto()
    {
        return $this->ventaProducto;
    }
}
