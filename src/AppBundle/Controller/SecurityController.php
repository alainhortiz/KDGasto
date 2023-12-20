<?php

namespace AppBundle\Controller;

use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('Inicio/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
            ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function login_checkAction()
    {
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/inicio", name="inicio")
     * @throws Exception
     */
    public function inicioAction()
    {
        $hoy = new DateTime('now');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $tiempoClave = $em->getRepository('AppBundle:Usuario')->verificarTiempoPassword($user->getId());

        $session = new Session();
        $session->set('comprobacion', false);

        if (!$session->get('comprobacion') && count($tiempoClave) !== 0) {
            $fechaFinal = new DateTime($tiempoClave[0]['fechaFinClave']->format('Y-m-d'));
            $cantDias = date_diff($hoy, $fechaFinal);
            if ($hoy <= $fechaFinal) {
                if ($cantDias->days >= 0 && $cantDias->days <= 5) {
                    return $this->render('Inicio/claveAlerta.html.twig', array(
                        'cantDias' => $cantDias->days
                    ));
                }
            } else {
                return $this->render('Inicio/claveVencida.html.twig');
            }
            $session->set('comprobacion', true);
        }

        $activo = $em->getRepository('AppBundle:PlanEstimadoIndicadores')->yearActivo();

        if (empty($activo)) {
            $totalEstimadoVenta = 0;
            $totalEstimadoRecursosHumanos = 0;
            $totalEstimadoOtrosGastos = 0;
            $totalEstimadoCombustible = 0;
            $totalEstimadoEnergia = 0;
            $totalEstimadoMateriaPrima = 0;
            $totalEstimadoDepreciacion = 0;
            $totalEstimadoAmortizacion = 0;
            $yearActivo = '';
            $idPlanEstimado = 0;
            $aprobarEstimadoVenta = false;
            $aprobarEstimadoRecursosHumanos = false;
            $aprobarEstimadoOtrosGastos = false;
            $aprobarEstimadoCombustible = false;
            $aprobarEstimadoEnergia = false;
            $aprobarEstimadoMateriaPrima = false;
            $aprobarEstimadoDepreciacion = false;
            $aprobarEstimadoAmortizacion = false;
            $aprobarEstimadoVentaMes = false;
            $aprobadoPlanVentas = false;
            $aprobadoPlanRecursosHumanos = false;
            $aprobadoPlanEnergia = false;
            $aprobarEstimadoCombustibleMes = false;
            $totalEstimadoVentaDivision = 0;
            $aprobarEstimadoFondoCentroCosto = false;
            $aprobarEstimadoEnergiaCentroCosto = false;
            $aprobarEstimadoOtrosGastosDivision = false;
            $aprobarEstimadoOtrosGastosCentroCosto = false;
            $aprobarEstimadoMateriaPrimaDivision = false;
            $aprobadoEstimadoMateriaPrima = false;
            $aprobarEstimadoDepreciacionDivision = false;
            $aprobadoEstimadoDepreciacion = false;
            $aprobadoEstimadoAmortizacion = false;
            $aprobadoEstimadoCombustible = false;
            $aprobarEstimadoLubricante = false;
        } else {
            $idPlanEstimado = $activo[0]->getId();
            $yearActivo = $activo[0]->getYear();
            $totalEstimadoVenta = $activo[0]->getTotalVenta();
            $totalEstimadoRecursosHumanos = $activo[0]->getTotalFondoSalario();
            $totalEstimadoOtrosGastos = $activo[0]->getTotalOtrosGastos();
            $totalEstimadoCombustible = $activo[0]->getTotalCombustible();
            $totalEstimadoEnergia = $activo[0]->getTotalEnergiaPresupuesto();
            $totalEstimadoMateriaPrima = $activo[0]->getTotalMateriaPrima();
            $totalEstimadoDepreciacion = $activo[0]->getTotalDepreciacion();
            $totalEstimadoAmortizacion = $activo[0]->getTotalAmortizacion();
            $aprobarEstimadoVenta = $activo[0]->getAprobarPrespuestoTotalVenta();
            $aprobadoPlanVentas = $activo[0]->getAprobarPrespuestoCentroCostoMesVenta();
            $aprobadoPlanRecursosHumanos = $activo[0]->getAprobarPrespuestoCentroCostoMesRecursosHumanos();
            $aprobadoPlanEnergia = $activo[0]->getAprobarPrespuestoCentroCostoMesEnergia();
            $aprobarEstimadoRecursosHumanos = $activo[0]->getAprobarPrespuestoTotalRecursosHumanos();
            $aprobarEstimadoOtrosGastos = $activo[0]->getAprobarPrespuestoTotalOtrosGastos();
            $aprobarEstimadoCombustible = $activo[0]->getAprobarPrespuestoTotalCombustible();
            $aprobarEstimadoFondoCentroCosto = $activo[0]->getAprobarPrespuestoDivisionMesRecursosHumanos();
            $aprobarEstimadoEnergiaCentroCosto = $activo[0]->getAprobarPrespuestoDivisionMesEnergia();
            $aprobarEstimadoOtrosGastosDivision = $activo[0]->getAprobarPrespuestoMesOtrosGastos();
            $aprobarEstimadoOtrosGastosCentroCosto = $activo[0]->getAprobarPrespuestoDivisionMesOtrosGastos();
            $aprobarEstimadoEnergia = $activo[0]->getAprobarPrespuestoTotalEnergia();
            $aprobarEstimadoMateriaPrima = $activo[0]->getAprobarPrespuestoTotalMateriaPrima();
            $aprobarEstimadoMateriaPrimaDivision = $activo[0]->getAprobarPrespuestoDivisionMateriaPrima();
            $aprobadoEstimadoMateriaPrima = $activo[0]->getAprobarPrespuestoCentroCostoMateriaPrima();
            $aprobarEstimadoDepreciacion = $activo[0]->getAprobarPrespuestoTotalDepreciacion();
            $aprobarEstimadoDepreciacionDivision = $activo[0]->getAprobarPrespuestoDivisionDepreciacion();
            $aprobadoEstimadoDepreciacion = $activo[0]->getAprobarPrespuestoCentroCostoDepreciacion();
            $aprobarEstimadoAmortizacion = $activo[0]->getAprobarPrespuestoTotalAmortizacion();
            $aprobarEstimadoAmortizacionDivision = $activo[0]->getAprobarPrespuestoDivisionAmortizacion();
            $aprobadoEstimadoAmortizacion = $activo[0]->getAprobarPrespuestoCentroCostoAmortizacion();
            $aprobadoEstimadoCombustible = $activo[0]->getAprobadoEstimadoCombustibleYLubricante();
            $aprobarEstimadoLubricante = $activo[0]->getAprobadoInicioLubricanteMedioTransporte();
            $inicioCentroCostoVentas = $em->getRepository('AppBundle:PlanEstimadoDivision')->verificarInicioEstimadoVentaCentroCosto($idPlanEstimado, $user->getCentroCosto()->getDivisionCentroCosto()->getId());
            if (empty($inicioCentroCostoVentas)) {
                $aprobarEstimadoVentaMes = false;
                $totalEstimadoVentaDivision = 0;
            } else {
                $aprobarEstimadoVentaMes = $inicioCentroCostoVentas[0]->getAprobadoPlanVentasMensualDivision();
                $totalEstimadoVentaDivision = $inicioCentroCostoVentas[0]->getTotalVentaDivision();
            }
        }

        $session->set('idPlanEstimado', $idPlanEstimado);
        $session->set('yearActivo', $yearActivo);
        $session->set('totalEstimadoVenta', $totalEstimadoVenta);
        $session->set('totalEstimadoRecursosHumanos', $totalEstimadoRecursosHumanos);
        $session->set('totalEstimadoOtrosGastos', $totalEstimadoOtrosGastos);
        $session->set('totalEstimadoCombustible', $totalEstimadoCombustible);
        $session->set('totalEstimadoEnergia', $totalEstimadoEnergia);
        $session->set('totalEstimadoMateriaPrima', $totalEstimadoMateriaPrima);
        $session->set('totalEstimadoDepreciacion', $totalEstimadoDepreciacion);
        $session->set('totalEstimadoAmortizacion', $totalEstimadoAmortizacion);
        $session->set('aprobarEstimadoRecursosHumanos', $aprobarEstimadoRecursosHumanos);
        if ($aprobarEstimadoRecursosHumanos) {
            if (($aprobarEstimadoVenta) || ($aprobarEstimadoVentaMes)) {
                $session->set('aprobarEstimadoRecursosHumanos', true);
            }
        }
        $session->set('aprobarEstimadoOtrosGastos', $aprobarEstimadoOtrosGastos);
        $session->set('aprobarEstimadoCombustible', $aprobarEstimadoCombustible);
        $session->set('aprobarEstimadoLubricante', $aprobarEstimadoLubricante);
        $session->set('aprobarEstimadoVenta', $aprobarEstimadoVenta);
        $session->set('aprobarEstimadoEnergia', $aprobarEstimadoEnergia);
        $session->set('aprobarEstimadoMateriaPrima', $aprobarEstimadoMateriaPrima);
        $session->set('aprobarEstimadoDepreciacion', $aprobarEstimadoDepreciacion);
        $session->set('aprobarEstimadoAmortizacion', $aprobarEstimadoAmortizacion);
        if ($aprobarEstimadoMateriaPrima) {
            if (($aprobarEstimadoVenta) || ($aprobarEstimadoVentaMes)) {
                $session->set('aprobarEstimadoMateriaPrima', true);
            }
        }
        $session->set('aprobarEstimadoVentaMes', $aprobarEstimadoVentaMes);
        $session->set('aprobadoPlanVentas', $aprobadoPlanVentas);
        $session->set('aprobadoPlanRecursosHumanos', $aprobadoPlanEnergia);
        $session->set('aprobadoPlanEnergia', $aprobadoPlanRecursosHumanos);
        $session->set('totalEstimadoVentaDivision', $totalEstimadoVentaDivision);
        $session->set('aprobarEstimadoFondoCentroCosto', $aprobarEstimadoFondoCentroCosto);
        $session->set('aprobarEstimadoEnergiaCentroCosto', $aprobarEstimadoEnergiaCentroCosto);
        $session->set('aprobarEstimadoOtrosGastosDivision', $aprobarEstimadoOtrosGastosDivision);
        $session->set('aprobarEstimadoOtrosGastosCentroCosto', $aprobarEstimadoOtrosGastosCentroCosto);
        $session->set('aprobarEstimadoMateriaPrimaDivision', $aprobarEstimadoMateriaPrimaDivision);
        $session->set('aprobadoMateriaPrima', $aprobadoEstimadoMateriaPrima);
        $session->set('aprobarEstimadoDepreciacionDivision', $aprobarEstimadoDepreciacionDivision);
        $session->set('aprobadoDepreciacion', $aprobadoEstimadoDepreciacion);
        $session->set('aprobarEstimadoAmortizacionDivision', $aprobarEstimadoAmortizacionDivision);
        $session->set('aprobadoAmortizacion', $aprobadoEstimadoAmortizacion);
        $session->set('aprobadoCombustible', $aprobadoEstimadoCombustible);

        //Dashboard de Ventas
        $graficosTotalesEstimadosDivisionesVentas  = $em->getRepository('AppBundle:PlanEstimadoDivision')->graficoTotalesEstimadosDivisionesVentas($idPlanEstimado);
        $graficosTotalesEstimadosMesesVentas  = $em->getRepository('AppBundle:PlanEstimadoDivisionMes')->graficoTotalesEstimadosMesesVentas($idPlanEstimado);

        //Dashboard de Fondo de Salario
        $graficosTotalesEstimadosDivisionesFondos  = $em->getRepository('AppBundle:PlanEstimadoDivisionSalario')->graficoTotalesEstimadosDivisionesFondos($idPlanEstimado);
        $graficosTotalesEstimadosMesesFondos  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesSalario')->graficosFondoEstimadoDivisionMensualTodos($idPlanEstimado);

        //Dashboard de Energia
        $graficosTotalesEstimadosDivisionesEnergias  = $em->getRepository('AppBundle:PlanEstimadoDivisionEnergia')->graficoTotalesEstimadosDivisionesEnergias($idPlanEstimado);
        $graficosTotalesEstimadosMesesEnergias  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesEnergia')->graficosEnergiaEstimadoDivisionMensualTodos($idPlanEstimado);

        //Dashboard de Otros Gastos
        $graficosTotalesEstimadosOtrosGastos  = $em->getRepository('AppBundle:PlanEstimadoOtrosGastos')->graficoTotalesEstimadosOtrosGastos($idPlanEstimado);
        $graficosTotalesEstimadosMesesOtrosGastos  = $em->getRepository('AppBundle:PlanEstimadoMesOtrosGastos')->graficosOtroGastoEstimadoMensualAgrupado($idPlanEstimado);

        //Dashboard de Materias Primas
        $graficosTotalesEstimadosDivisionesMateriasPrimas  = $em->getRepository('AppBundle:PlanEstimadoDivisionMateriaPrima')->graficoTotalesEstimadosDivisionesMateriasPrimas($idPlanEstimado);
        $graficosTotalesEstimadosMesesmateriasPrimas  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesMateriaPrima')->graficoTotalesEstimadosMesesMateriasPrimas($idPlanEstimado);

        //Dashboard de Depreciación
        $graficosTotalesEstimadosDivisionesDepreciaciones  = $em->getRepository('AppBundle:PlanEstimadoDivisionDepreciacion')->graficoTotalesEstimadosDivisionesDepreciacion($idPlanEstimado);
        $graficosTotalesEstimadosMesesDepreciaciones  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesDepreciacion')->graficoTotalesEstimadosMesesDepreciaciones($idPlanEstimado);

        //Dashboard de Amortización
        $graficosTotalesEstimadosDivisionesAmortizaciones  = $em->getRepository('AppBundle:PlanEstimadoDivisionAmortizacion')->graficoTotalesEstimadosDivisionesAmortizacion($idPlanEstimado);
        $graficosTotalesEstimadosMesesAmortizaciones  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesAmortizacion')->graficoTotalesEstimadosMesesAmortizaciones($idPlanEstimado);

        $divisionCentrosCostos  = $em->getRepository('AppBundle:DivisionCentroCosto')->findAll();
        $centrosCostos  = $em->getRepository('AppBundle:CentroCosto')->findAll();
        $otrosGastos  = $em->getRepository('AppBundle:OtroGasto')->findAll();

        return $this->render('Inicio/inicio.html.twig', array(
            'graficosTotalesEstimadosDivisionesVentas' => $graficosTotalesEstimadosDivisionesVentas,
            'divisionCentrosCostos' => $divisionCentrosCostos,
            'centrosCostos' => $centrosCostos,
            'otrosGastos' => $otrosGastos,
            'graficosTotalesEstimadosMesesVentas' => $graficosTotalesEstimadosMesesVentas,
            'graficosTotalesEstimadosDivisionesFondos' => $graficosTotalesEstimadosDivisionesFondos,
            'graficosTotalesEstimadosMesesFondos' => $graficosTotalesEstimadosMesesFondos,
            'graficosTotalesEstimadosDivisionesEnergias' => $graficosTotalesEstimadosDivisionesEnergias,
            'graficosTotalesEstimadosMesesEnergias' => $graficosTotalesEstimadosMesesEnergias,
            'graficosTotalesEstimadosOtrosGastos' => $graficosTotalesEstimadosOtrosGastos,
            'graficosTotalesEstimadosMesesOtrosGastos' => $graficosTotalesEstimadosMesesOtrosGastos,
            'graficosTotalesEstimadosDivisionesMateriasPrimas' => $graficosTotalesEstimadosDivisionesMateriasPrimas,
            'graficosTotalesEstimadosMesesmateriasPrimas' => $graficosTotalesEstimadosMesesmateriasPrimas,
            'graficosTotalesEstimadosDivisionesDepreciaciones' => $graficosTotalesEstimadosDivisionesDepreciaciones,
            'graficosTotalesEstimadosMesesDepreciaciones' => $graficosTotalesEstimadosMesesDepreciaciones,
            'graficosTotalesEstimadosDivisionesAmortizaciones' => $graficosTotalesEstimadosDivisionesAmortizaciones,
            'graficosTotalesEstimadosMesesAmortizaciones' => $graficosTotalesEstimadosMesesAmortizaciones

        ));

    }

    /**
     * @Route("/inicio2", name="inicio2")
     */
    public function inicio2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $session = new Session();

        $activo = $em->getRepository('AppBundle:PlanEstimadoIndicadores')->yearActivo();

        if (empty($activo)) {
            $totalEstimadoVenta = 0;
            $totalEstimadoRecursosHumanos = 0;
            $totalEstimadoOtrosGastos = 0;
            $totalEstimadoCombustible = 0;
            $totalEstimadoEnergia = 0;
            $totalEstimadoMateriaPrima = 0;
            $totalEstimadoDepreciacion = 0;
            $totalEstimadoAmortizacion = 0;
            $yearActivo = '';
            $idPlanEstimado = 0;
            $aprobarEstimadoVenta = false;
            $aprobarEstimadoRecursosHumanos = false;
            $aprobarEstimadoOtrosGastos = false;
            $aprobarEstimadoCombustible = false;
            $aprobarEstimadoEnergia = false;
            $aprobarEstimadoMateriaPrima = false;
            $aprobarEstimadoDepreciacion = false;
            $aprobarEstimadoAmortizacion = false;
            $aprobarEstimadoVentaMes = false;
            $aprobadoPlanVentas = false;
            $aprobadoPlanRecursosHumanos = false;
            $aprobadoPlanEnergia = false;
            $aprobarEstimadoCombustibleMes = false;
            $totalEstimadoVentaDivision = 0;
            $aprobarEstimadoFondoCentroCosto = false;
            $aprobarEstimadoEnergiaCentroCosto = false;
            $aprobarEstimadoOtrosGastosDivision = false;
            $aprobarEstimadoOtrosGastosCentroCosto = false;
            $aprobarEstimadoMateriaPrimaDivision = false;
            $aprobadoEstimadoMateriaPrima = false;
            $aprobarEstimadoDepreciacionDivision = false;
            $aprobadoEstimadoDepreciacion = false;
            $aprobadoEstimadoAmortizacion = false;
            $aprobadoEstimadoCombustible = false;
            $aprobarEstimadoLubricante = false;
        } else {
            $idPlanEstimado = $activo[0]->getId();
            $yearActivo = $activo[0]->getYear();
            $totalEstimadoVenta = $activo[0]->getTotalVenta();
            $totalEstimadoRecursosHumanos = $activo[0]->getTotalFondoSalario();
            $totalEstimadoOtrosGastos = $activo[0]->getTotalOtrosGastos();
            $totalEstimadoCombustible = $activo[0]->getTotalCombustible();
            $totalEstimadoEnergia = $activo[0]->getTotalEnergiaPresupuesto();
            $totalEstimadoMateriaPrima = $activo[0]->getTotalMateriaPrima();
            $totalEstimadoDepreciacion = $activo[0]->getTotalDepreciacion();
            $totalEstimadoAmortizacion = $activo[0]->getTotalAmortizacion();
            $aprobarEstimadoVenta = $activo[0]->getAprobarPrespuestoTotalVenta();
            $aprobadoPlanVentas = $activo[0]->getAprobarPrespuestoCentroCostoMesVenta();
            $aprobadoPlanRecursosHumanos = $activo[0]->getAprobarPrespuestoCentroCostoMesRecursosHumanos();
            $aprobadoPlanEnergia = $activo[0]->getAprobarPrespuestoCentroCostoMesEnergia();
            $aprobarEstimadoRecursosHumanos = $activo[0]->getAprobarPrespuestoTotalRecursosHumanos();
            $aprobarEstimadoOtrosGastos = $activo[0]->getAprobarPrespuestoTotalOtrosGastos();
            $aprobarEstimadoCombustible = $activo[0]->getAprobarPrespuestoTotalCombustible();
            $aprobarEstimadoFondoCentroCosto = $activo[0]->getAprobarPrespuestoDivisionMesRecursosHumanos();
            $aprobarEstimadoEnergiaCentroCosto = $activo[0]->getAprobarPrespuestoDivisionMesEnergia();
            $aprobarEstimadoOtrosGastosDivision = $activo[0]->getAprobarPrespuestoMesOtrosGastos();
            $aprobarEstimadoOtrosGastosCentroCosto = $activo[0]->getAprobarPrespuestoDivisionMesOtrosGastos();
            $aprobarEstimadoEnergia = $activo[0]->getAprobarPrespuestoTotalEnergia();
            $aprobarEstimadoMateriaPrima = $activo[0]->getAprobarPrespuestoTotalMateriaPrima();
            $aprobarEstimadoMateriaPrimaDivision = $activo[0]->getAprobarPrespuestoDivisionMateriaPrima();
            $aprobadoEstimadoMateriaPrima = $activo[0]->getAprobarPrespuestoCentroCostoMateriaPrima();
            $aprobarEstimadoDepreciacion = $activo[0]->getAprobarPrespuestoTotalDepreciacion();
            $aprobarEstimadoDepreciacionDivision = $activo[0]->getAprobarPrespuestoDivisionDepreciacion();
            $aprobadoEstimadoDepreciacion = $activo[0]->getAprobarPrespuestoCentroCostoDepreciacion();
            $aprobarEstimadoAmortizacion = $activo[0]->getAprobarPrespuestoTotalAmortizacion();
            $aprobarEstimadoAmortizacionDivision = $activo[0]->getAprobarPrespuestoDivisionAmortizacion();
            $aprobadoEstimadoAmortizacion = $activo[0]->getAprobarPrespuestoCentroCostoAmortizacion();
            $aprobadoEstimadoCombustible = $activo[0]->getAprobadoEstimadoCombustibleYLubricante();
            $aprobarEstimadoLubricante = $activo[0]->getAprobadoInicioLubricanteMedioTransporte();
            $inicioCentroCostoVentas = $em->getRepository('AppBundle:PlanEstimadoDivision')->verificarInicioEstimadoVentaCentroCosto($idPlanEstimado, $user->getCentroCosto()->getDivisionCentroCosto()->getId());
            if (empty($inicioCentroCostoVentas)) {
                $aprobarEstimadoVentaMes = false;
                $totalEstimadoVentaDivision = 0;
            } else {
                $aprobarEstimadoVentaMes = $inicioCentroCostoVentas[0]->getAprobadoPlanVentasMensualDivision();
                $totalEstimadoVentaDivision = $inicioCentroCostoVentas[0]->getTotalVentaDivision();
            }
        }

        $session->set('idPlanEstimado', $idPlanEstimado);
        $session->set('yearActivo', $yearActivo);
        $session->set('totalEstimadoVenta', $totalEstimadoVenta);
        $session->set('totalEstimadoRecursosHumanos', $totalEstimadoRecursosHumanos);
        $session->set('totalEstimadoOtrosGastos', $totalEstimadoOtrosGastos);
        $session->set('totalEstimadoCombustible', $totalEstimadoCombustible);
        $session->set('totalEstimadoEnergia', $totalEstimadoEnergia);
        $session->set('totalEstimadoMateriaPrima', $totalEstimadoMateriaPrima);
        $session->set('totalEstimadoDepreciacion', $totalEstimadoDepreciacion);
        $session->set('totalEstimadoAmortizacion', $totalEstimadoAmortizacion);
        $session->set('aprobarEstimadoRecursosHumanos', $aprobarEstimadoRecursosHumanos);
        if ($aprobarEstimadoRecursosHumanos) {
            if (($aprobarEstimadoVenta) || ($aprobarEstimadoVentaMes)) {
                $session->set('aprobarEstimadoRecursosHumanos', true);
            }
        }
        $session->set('aprobarEstimadoOtrosGastos', $aprobarEstimadoOtrosGastos);
        $session->set('aprobarEstimadoCombustible', $aprobarEstimadoCombustible);
        $session->set('aprobarEstimadoLubricante', $aprobarEstimadoLubricante);
        $session->set('aprobarEstimadoVenta', $aprobarEstimadoVenta);
        $session->set('aprobarEstimadoEnergia', $aprobarEstimadoEnergia);
        $session->set('aprobarEstimadoMateriaPrima', $aprobarEstimadoMateriaPrima);
        $session->set('aprobarEstimadoDepreciacion', $aprobarEstimadoDepreciacion);
        $session->set('aprobarEstimadoAmortizacion', $aprobarEstimadoAmortizacion);
        if ($aprobarEstimadoMateriaPrima) {
            if (($aprobarEstimadoVenta) || ($aprobarEstimadoVentaMes)) {
                $session->set('aprobarEstimadoMateriaPrima', true);
            }
        }
        $session->set('aprobarEstimadoVentaMes', $aprobarEstimadoVentaMes);
        $session->set('aprobadoPlanVentas', $aprobadoPlanVentas);
        $session->set('aprobadoPlanRecursosHumanos', $aprobadoPlanEnergia);
        $session->set('aprobadoPlanEnergia', $aprobadoPlanRecursosHumanos);
        $session->set('totalEstimadoVentaDivision', $totalEstimadoVentaDivision);
        $session->set('aprobarEstimadoFondoCentroCosto', $aprobarEstimadoFondoCentroCosto);
        $session->set('aprobarEstimadoEnergiaCentroCosto', $aprobarEstimadoEnergiaCentroCosto);
        $session->set('aprobarEstimadoOtrosGastosDivision', $aprobarEstimadoOtrosGastosDivision);
        $session->set('aprobarEstimadoOtrosGastosCentroCosto', $aprobarEstimadoOtrosGastosCentroCosto);
        $session->set('aprobarEstimadoMateriaPrimaDivision', $aprobarEstimadoMateriaPrimaDivision);
        $session->set('aprobadoMateriaPrima', $aprobadoEstimadoMateriaPrima);
        $session->set('aprobarEstimadoDepreciacionDivision', $aprobarEstimadoDepreciacionDivision);
        $session->set('aprobadoDepreciacion', $aprobadoEstimadoDepreciacion);
        $session->set('aprobarEstimadoAmortizacionDivision', $aprobarEstimadoAmortizacionDivision);
        $session->set('aprobadoAmortizacion', $aprobadoEstimadoAmortizacion);
        $session->set('aprobadoCombustible', $aprobadoEstimadoCombustible);

        //Dashboard de Ventas
        $graficosTotalesEstimadosDivisionesVentas  = $em->getRepository('AppBundle:PlanEstimadoDivision')->graficoTotalesEstimadosDivisionesVentas($idPlanEstimado);
        $graficosTotalesEstimadosMesesVentas  = $em->getRepository('AppBundle:PlanEstimadoDivisionMes')->graficoTotalesEstimadosMesesVentas($idPlanEstimado);

        //Dashboard de Fondo de Salario
        $graficosTotalesEstimadosDivisionesFondos  = $em->getRepository('AppBundle:PlanEstimadoDivisionSalario')->graficoTotalesEstimadosDivisionesFondos($idPlanEstimado);
        $graficosTotalesEstimadosMesesFondos  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesSalario')->graficosFondoEstimadoDivisionMensualTodos($idPlanEstimado);

        //Dashboard de Energia
        $graficosTotalesEstimadosDivisionesEnergias  = $em->getRepository('AppBundle:PlanEstimadoDivisionEnergia')->graficoTotalesEstimadosDivisionesEnergias($idPlanEstimado);
        $graficosTotalesEstimadosMesesEnergias  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesEnergia')->graficosEnergiaEstimadoDivisionMensualTodos($idPlanEstimado);

        //Dashboard de Otros Gastos
        $graficosTotalesEstimadosOtrosGastos  = $em->getRepository('AppBundle:PlanEstimadoOtrosGastos')->graficoTotalesEstimadosOtrosGastos($idPlanEstimado);
        $graficosTotalesEstimadosMesesOtrosGastos  = $em->getRepository('AppBundle:PlanEstimadoMesOtrosGastos')->graficosOtroGastoEstimadoMensualAgrupado($idPlanEstimado);

        //Dashboard de Materias Primas
        $graficosTotalesEstimadosDivisionesMateriasPrimas  = $em->getRepository('AppBundle:PlanEstimadoDivisionMateriaPrima')->graficoTotalesEstimadosDivisionesMateriasPrimas($idPlanEstimado);
        $graficosTotalesEstimadosMesesmateriasPrimas  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesMateriaPrima')->graficoTotalesEstimadosMesesMateriasPrimas($idPlanEstimado);

        //Dashboard de Depreciación
        $graficosTotalesEstimadosDivisionesDepreciaciones  = $em->getRepository('AppBundle:PlanEstimadoDivisionDepreciacion')->graficoTotalesEstimadosDivisionesDepreciacion($idPlanEstimado);
        $graficosTotalesEstimadosMesesDepreciaciones  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesDepreciacion')->graficoTotalesEstimadosMesesDepreciaciones($idPlanEstimado);

        //Dashboard de Amortización
        $graficosTotalesEstimadosDivisionesAmortizaciones  = $em->getRepository('AppBundle:PlanEstimadoDivisionAmortizacion')->graficoTotalesEstimadosDivisionesAmortizacion($idPlanEstimado);
        $graficosTotalesEstimadosMesesAmortizaciones  = $em->getRepository('AppBundle:PlanEstimadoDivisionMesAmortizacion')->graficoTotalesEstimadosMesesAmortizaciones($idPlanEstimado);

        $divisionCentrosCostos  = $em->getRepository('AppBundle:DivisionCentroCosto')->findAll();
        $centrosCostos  = $em->getRepository('AppBundle:CentroCosto')->findAll();
        $otrosGastos  = $em->getRepository('AppBundle:OtroGasto')->findAll();

        return $this->render('Inicio/inicio.html.twig', array(
            'graficosTotalesEstimadosDivisionesVentas' => $graficosTotalesEstimadosDivisionesVentas,
            'divisionCentrosCostos' => $divisionCentrosCostos,
            'centrosCostos' => $centrosCostos,
            'otrosGastos' => $otrosGastos,
            'graficosTotalesEstimadosMesesVentas' => $graficosTotalesEstimadosMesesVentas,
            'graficosTotalesEstimadosDivisionesFondos' => $graficosTotalesEstimadosDivisionesFondos,
            'graficosTotalesEstimadosMesesFondos' => $graficosTotalesEstimadosMesesFondos,
            'graficosTotalesEstimadosDivisionesEnergias' => $graficosTotalesEstimadosDivisionesEnergias,
            'graficosTotalesEstimadosMesesEnergias' => $graficosTotalesEstimadosMesesEnergias,
            'graficosTotalesEstimadosOtrosGastos' => $graficosTotalesEstimadosOtrosGastos,
            'graficosTotalesEstimadosMesesOtrosGastos' => $graficosTotalesEstimadosMesesOtrosGastos,
            'graficosTotalesEstimadosDivisionesMateriasPrimas' => $graficosTotalesEstimadosDivisionesMateriasPrimas,
            'graficosTotalesEstimadosMesesmateriasPrimas' => $graficosTotalesEstimadosMesesmateriasPrimas,
            'graficosTotalesEstimadosDivisionesDepreciaciones' => $graficosTotalesEstimadosDivisionesDepreciaciones,
            'graficosTotalesEstimadosMesesDepreciaciones' => $graficosTotalesEstimadosMesesDepreciaciones,
            'graficosTotalesEstimadosDivisionesAmortizaciones' => $graficosTotalesEstimadosDivisionesAmortizaciones,
            'graficosTotalesEstimadosMesesAmortizaciones' => $graficosTotalesEstimadosMesesAmortizaciones

        ));

    }

    /**
     * @Route("/passwordForm", name="passwordForm")
     */
    public function passwordFormAction()
    {
        return $this->render('Nomencladores/GestionUsuario/cambiarPassword.html.twig');
    }

    /**
     * @Route("/changePassword", name="changePassword")
     */
    public function changePasswordAction()
    {
        $peticion = Request::createFromGlobals();
        $idUsuario = $peticion->request->get('idUsuario');
        $username = $peticion->request->get('username');
        $passAnt = $peticion->request->get('passAnt');
        $passNew = $peticion->request->get('passNew');
        $user = $this->getUser();

        $encoder = $this->container->get('security.password_encoder');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Usuario');
        $usuario = $repository->findOneBy(array('username' => $username));
        $valid = $encoder->isPasswordValid($usuario, $passAnt);

        if (!$valid) {
            return new Response('Error: Contraseña actual errónea');
        }

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
                'operacion' => 'Cambio de contraseña de Usuario',
                'descripcion' => 'Se cambió la contraseña del usuario: ' . $user->getNombre() . ' ' . $user->getPrimerApellido() . ' ' . $user->getSegundoApellido()
            );
            $traza = $em->getRepository('AppBundle:Traza')->guardarTraza($dataTraza);
            if ($traza !== 'ok') return new Response($traza);
            return new Response('ok');
        }
    }

    //metodo para mostrar pantalla de bloqueo

    /**
     * @Route("/lock", name="lock")
     */
    public function lockAction()
    {
        return $this->render('Inicio/lock.html.twig');
    }

    //metodo para desbloquear el sistema

    /**
     * @Route("/confirmPassword", name="confirmPassword")
     */
    public function confirmPasswordAction()
    {
        $peticion = Request::createFromGlobals();
        $password = $peticion->request->get('password');
        $user = $this->getUser();

        $encoder = $this->container->get('security.password_encoder');

        /*$em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Usuario');
        $user = $repository->findOneBy(array('username' => $username));*/
        $valid = $encoder->isPasswordValid($user, $password);

        if ($valid === 1) {
            return new Response('ok');
        } else {
            return new Response('Error: Contraseña  errónea');
        }
    }
}
