<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements AdvancedUserInterface , Serializable
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
     * @ORM\Column(name="username", type="string", length=100, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primerApellido", type="string", length=100)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoApellido", type="string", length=100)
     */
    private $segundoApellido;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaFinClave", type="date")
     */
    private $fechaFinClave;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="usuario_role",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $usuario_roles;

    /**
     * @ORM\ManyToMany(targetEntity="NivelAcceso")
     * @ORM\JoinTable(name="usuario_nivel_acceso",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="nivel_acceso_id", referencedColumnName="id")}
     * )
     */
    private $usuario_nivelAccesos;

    /**
     * @ORM\OneToMany(targetEntity="VentaProducto", mappedBy="usuario")
     */
    private $ventasProductos;

    /**
     * @ORM\OneToMany(targetEntity="ProductoModalidadPago", mappedBy="usuario")
     */
    private $modalidadesPagos;

    /**
     * Usuario constructor.
     */
    public function __construct()
    {
        $this->usuario_roles = new ArrayCollection();
        $this->ventasProductos = new ArrayCollection();
        $this->isActive = true;
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
     * Set username
     *
     * @param string $username
     *
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
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
     * Set primerApellido
     *
     * @param string $primerApellido
     *
     * @return Usuario
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     *
     * @return Usuario
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundoApellido
     *
     * @return string
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add usuarioRole
     *
     * @param Role $usuarioRole
     *
     * @return Usuario
     */
    public function addUsuarioRole(Role $usuarioRole)
    {
        $this->usuario_roles[] = $usuarioRole;

        return $this;
    }

    /**
     * Remove usuarioRole
     *
     * @param Role $usuarioRole
     */
    public function removeUsuarioRole(Role $usuarioRole)
    {
        $this->usuario_roles->removeElement($usuarioRole);
    }

    /**
     * Get usuarioRoles
     *
     * @return Collection
     */
    public function getUsuarioRoles()
    {
        return $this->usuario_roles;
    }

    // Inicio metodos para el mecanismo de seguridad
    public function setUsuarioRoles($roles)
    {
        $this->usuario_roles = $roles;
    }

    public function setUsuarioNivelesAccesos($nivelAccesos)
    {
        $this->usuario_nivelAccesos = $nivelAccesos;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
            ) = unserialize($serialized);
    }

    public function getRoles()
    {
        //IMPORTANTE: el mecanismo de seguridad de Sf2 requiere ésto como un array

        $roles = array();
        foreach ($this->usuario_roles as $role) {
            $roles[] = $role->getRole();
        }
        return $roles;
    }

    public function getNivelAccesos()
    {
        //IMPORTANTE: el mecanismo de seguridad de Sf2 requiere ésto como un array

        $nivelAccesos = array();
        foreach ($this->usuario_nivelAccesos as $nivelAcceso) {
            $nivelAccesos[] = $nivelAcceso->getNivel();
        }
        return $nivelAccesos;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    // Fin metodos para el mecanismo de seguridad

    /**
     * Get nombreCompleto
     *
     * @return string
     */
    public function nombreCompleto()
    {
        return $this->getNombre() . ' ' . $this->getPrimerApellido() . ' ' . $this->getSegundoApellido();
    }


    /**
     * Set fechaFinClave
     *
     * @param DateTime $fechaFinClave
     *
     * @return Usuario
     */
    public function setFechaFinClave($fechaFinClave)
    {
        $this->fechaFinClave = $fechaFinClave;

        return $this;
    }

    /**
     * Get fechaFinClave
     *
     * @return DateTime
     */
    public function getFechaFinClave()
    {
        return $this->fechaFinClave;
    }


    /**
     * Add usuarioNivelAcceso
     *
     * @param NivelAcceso $usuarioNivelAcceso
     *
     * @return Usuario
     */
    public function addUsuarioNivelAcceso(NivelAcceso $usuarioNivelAcceso)
    {
        $this->usuario_nivelAccesos[] = $usuarioNivelAcceso;

        return $this;
    }

    /**
     * Remove usuarioNivelAcceso
     *
     * @param NivelAcceso $usuarioNivelAcceso
     */
    public function removeUsuarioNivelAcceso(NivelAcceso $usuarioNivelAcceso)
    {
        $this->usuario_nivelAccesos->removeElement($usuarioNivelAcceso);
    }

    /**
     * Get usuarioNivelAccesos
     *
     * @return Collection
     */
    public function getUsuarioNivelAccesos()
    {
        return $this->usuario_nivelAccesos;
    }

    /**
     * Add ventasProducto
     *
     * @param \AppBundle\Entity\VentaProducto $ventasProducto
     *
     * @return Usuario
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

    /**
     * Add modalidadesPago
     *
     * @param \AppBundle\Entity\ProductoModalidadPago $modalidadesPago
     *
     * @return Usuario
     */
    public function addModalidadesPago(\AppBundle\Entity\ProductoModalidadPago $modalidadesPago)
    {
        $this->modalidadesPagos[] = $modalidadesPago;

        return $this;
    }

    /**
     * Remove modalidadesPago
     *
     * @param \AppBundle\Entity\ProductoModalidadPago $modalidadesPago
     */
    public function removeModalidadesPago(\AppBundle\Entity\ProductoModalidadPago $modalidadesPago)
    {
        $this->modalidadesPagos->removeElement($modalidadesPago);
    }

    /**
     * Get modalidadesPagos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModalidadesPagos()
    {
        return $this->modalidadesPagos;
    }
}
