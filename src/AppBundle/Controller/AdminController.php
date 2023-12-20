<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\Cloner\VarCloner;

class AdminController extends Controller
{
    /**
     * @Route("/gestionarUsuarios", name="gestionarUsuarios")
     */
    public function gestionarUsuariosAccion()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();

        return $this->render('Nomencladores/GestionUsuario/gestionUsuarios.html.twig', array(
            'usuarios' => $usuarios
        ));
    }

    /**
     * @Route("/addUsuario", name="addUsuario")
     */
    public function addUsuarioAction()
    {
        $em = $this->getDoctrine()->getManager();

        $divisionCentrosCostos = $em->getRepository('AppBundle:DivisionCentroCosto')->findAll();
        $centrosCostos = $em->getRepository('AppBundle:CentroCosto')->findAll();
        $nivelAccesos = $em->getRepository('AppBundle:NivelAcceso')->findAll();
        $roles = $em->getRepository('AppBundle:Role')->findAll();

        return $this->render('Nomencladores/GestionUsuario/addUsuario.html.twig', array(
                'roles' => $roles,
                'divisionCentrosCostos' => $divisionCentrosCostos,
                'centrosCostos' => $centrosCostos,
                'nivelAccesos' => $nivelAccesos)
        );
    }

    /**
     * @Route("/insertUsuario", name="insertUsuario")
     */
    public function insertUsuarioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $resp = $em->getRepository('AppBundle:Usuario')->verificarPassword($peticion->request->get('clave'));

        if ($resp !== 'ok') {
            return new Response($resp);
        }

        $data = array(
            'username' => $peticion->request->get('username'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'centroCosto' => $peticion->request->get('centroCosto'),
            'clave' => $peticion->request->get('clave'),
            'modulos' => $peticion->request->get('modulos'),
            'roles' => $peticion->request->get('roles')
        );

        $usuario = $em->getRepository('AppBundle:Usuario')->agregarUsuario($data);

        if (is_string($usuario)) return new Response($usuario);
        else {
            $dataTraza = array(
                'username' => $user->getUsername(),
                'nombre' => $user->getNombre(),
                'operacion' => 'Insertar Usuario',
                'descripcion' => 'Se insertó el usuario: ' . $data['nombre'] . ' ' . $data['primerApellido'] . ' ' . $data['segundoApellido']
            );
            $traza = $em->getRepository('AppBundle:Traza')->guardarTraza($dataTraza);
            if ($traza !== 'ok') return new Response($traza);
            return new Response('ok');

        }
    }

    /**
     * @Route("/editUsuario/{idUsuario}", name="editUsuario")
     */
    public function editUsuarioAction($idUsuario)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('AppBundle:Usuario')->find($idUsuario);
        $divisionCentrosCostos = $em->getRepository('AppBundle:DivisionCentroCosto')->findAll();
        $centrosCostos = $em->getRepository('AppBundle:CentroCosto')->findAll();
        $nivelAccesos = $em->getRepository('AppBundle:NivelAcceso')->findAll();
        $roles = $em->getRepository('AppBundle:Role')->findAll();


        return $this->render('Nomencladores/GestionUsuario/editUsuario.html.twig', array(
                'usuario' => $usuario,
                'divisionCentrosCostos' => $divisionCentrosCostos,
                'centrosCostos' => $centrosCostos,
                'nivelAccesos' => $nivelAccesos,
                'roles' => $roles)
        );
    }

    /**
     * @Route("/updateUsuario", name="updateUsuario")
     */
    public function updateUsuarioAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $data = array(
            'idUsuario' => $peticion->request->get('idUsuario'),
            'username' => $peticion->request->get('username'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'centroCosto' => $peticion->request->get('centroCosto'),
            'modulos' => $peticion->request->get('modulos'),
            'roles' => $peticion->request->get('roles'),
            'activo' => $peticion->request->get('activo')
        );

        $resp = $em->getRepository('AppBundle:Usuario')->modificarUsuario($data);

        if (is_string($resp)) return new Response($resp);
        else {
            $dataTraza = array(
                'username' => $user->getUsername(),
                'nombre' => $user->getNombre(),
                'operacion' => 'Modificar Usuario',
                'descripcion' => 'Se modificó el usuario: ' . $data['nombre'] . ' ' . $data['primerApellido'] . ' ' . $data['segundoApellido']
            );
            $traza = $em->getRepository('AppBundle:Traza')->guardarTraza($dataTraza);
            if ($traza != 'ok') return new Response($traza);
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteUsuario", name="deleteUsuario")
     */
    public function deleteUsuarioAccion()
    {
        $peticion = Request::createFromGlobals();
        $user = $this->getUser();
        $idUsuario = $peticion->request->get('idUsuario');
        $em = $this->getDoctrine()->getManager();

        $resp = $em->getRepository('AppBundle:Usuario')->eliminarUsuario($idUsuario);

        if (is_string($resp)) return new Response($resp);
        else {
            $dataTraza = array(
                'username' => $user->getUsername(),
                'nombre' => $user->getNombre(),
                'operacion' => 'Eliminar Usuario',
                'descripcion' => 'Se eliminó el usuario: ' . $resp->getNombre() . ' ' . $resp->getPrimerApellido() . ' ' . $resp->getSegundoApellido()
            );
            $traza = $em->getRepository('AppBundle:Traza')->guardarTraza($dataTraza);
            if ($traza != 'ok') return new Response($traza);
            return new Response('ok');
        }
    }

    /**
     * @Route("/desactivarUsuario", name="desactivarUsuario")
     */
    public function desactivarUsuarioAccion()
    {
        $peticion = Request::createFromGlobals();
        $user = $this->getUser();
        $idUsuario = $peticion->request->get('idUsuario');
        $em = $this->getDoctrine()->getManager();

        $resp = $em->getRepository('AppBundle:Usuario')->desactivarrUsuario($idUsuario);

        if (is_string($resp)) return new Response($resp);
        else {
            $dataTraza = array(
                'username' => $user->getUsername(),
                'nombre' => $user->getNombre(),
                'operacion' => 'Desactivar Usuario',
                'descripcion' => 'Se desactivó el usuario: ' . $resp->getNombre() . ' ' . $resp->getPrimerApellido() . ' ' . $resp->getSegundoApellido()
            );
            $traza = $em->getRepository('AppBundle:Traza')->guardarTraza($dataTraza);
            if ($traza != 'ok') return new Response($traza);
            return new Response('ok');
        }
    }

    /**
     * @Route("/resetearPasswordForm/{idUsuario}", name="resetearPasswordForm")
     */
    public function resetearPasswordFormAction($idUsuario)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $usuario = $em->getRepository('AppBundle:Usuario')->find($idUsuario);

        $dataTraza = array(
            'username' => $user->getUsername(),
            'nombre' => $user->getNombre(),
            'operacion' => 'Acceso al Formulario',
            'descripcion' => 'Acceso al Formulario resetear password'
        );

        $traza = $em->getRepository('AppBundle:Traza')->guardarTraza($dataTraza);
        if ($traza != 'ok') return new Response($traza);

        return $this->render('Nomencladores/GestionUsuario/resetearPassword.html.twig', array(
            'usuario' => $usuario));
    }

    /**
     * @Route("/resetarPassword", name="resetarPassword")
     */
    public function resetarPasswordAction()
    {
        $peticion = Request::createFromGlobals();
        $idUsuario = $peticion->request->get('idUsuario');
        $passNew = $peticion->request->get('passNew');

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $usuario = $em->getRepository('AppBundle:Usuario')->find($idUsuario);

        $resp = $em->getRepository('AppBundle:Usuario')->verificarPassword($passNew);
        if ($resp !== 'ok') {
            return new Response($resp);
        }

        $resp = $em->getRepository('AppBundle:Usuario')->verificarPasswordAnterior($idUsuario, $passNew);
        if ($resp) {
            return new Response('Error: No se puede utilizar la contraseña anterior');
        }

        $resp = $em->getRepository('AppBundle:Usuario')->cambiarPassword($idUsuario, $passNew);
        if (is_string($resp)) return new Response($resp);
        else {
            $dataTraza = array(
                'username' => $user->getUsername(),
                'nombre' => $user->getNombre(),
                'operacion' => 'Resetear contraseña de Usuario',
                'descripcion' => 'Se reseteó la contraseña del usuario: ' . $usuario->getNombre() . ' ' . $usuario->getPrimerApellido() . ' ' . $usuario->getSegundoApellido()
            );
            $traza = $em->getRepository('AppBundle:Traza')->guardarTraza($dataTraza);
            if ($traza != 'ok') return new Response($traza);
            return new Response('ok');
        }
    }

}
