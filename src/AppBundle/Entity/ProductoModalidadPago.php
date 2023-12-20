<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoModalidadPago
 *
 * @ORM\Table(name="producto_modalidad_pago")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoModalidadPagoRepository")
 */
class ProductoModalidadPago
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
     * @ORM\Column(name="importePagado", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $importePagado = 0;

    /**
     * @ORM\ManyToOne(targetEntity="VentaProducto",inversedBy="modalidadesPagos")
     */
    protected $ventaProducto;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario",inversedBy="modalidadesPagos")
     */
    protected $usuario;

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
     * Set importePagado
     *
     * @param string $importePagado
     *
     * @return ProductoModalidadPago
     */
    public function setImportePagado($importePagado)
    {
        $this->importePagado = $importePagado;

        return $this;
    }

    /**
     * Get importePagado
     *
     * @return string
     */
    public function getImportePagado()
    {
        return $this->importePagado;
    }

    /**
     * Set ventaProducto
     *
     * @param \AppBundle\Entity\VentaProducto $ventaProducto
     *
     * @return ProductoModalidadPago
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

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return ProductoModalidadPago
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
