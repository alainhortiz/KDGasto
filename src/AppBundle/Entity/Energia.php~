<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Energia
 *
 * @ORM\Table(name="energia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnergiaRepository")
 */
class Energia
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
     * @ORM\Column(name="unidad", type="string", length=5)
     */
    private $unidad;

    /**
     * @var int
     *
     * @ORM\Column(name="precio", type="decimal", precision=18, scale=4, nullable=false)
     */
    private $precio = 0;

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
     * Set unidad
     *
     * @param string $unidad
     *
     * @return Energia
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return string
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return Energia
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
}
