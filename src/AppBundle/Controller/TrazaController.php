<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrazaController extends Controller
{
    /**
     * @Route("/trazas", name="trazas")
     */
    public function mostrarTrazasAction()
    {
        $em = $this->getDoctrine()->getManager();

        /*$trazas = $em->getRepository('AppBundle:Traza')->findAll();*/

        $data['recordsTotal'] = $em->createQuery('SELECT count(t) FROM AppBundle:Traza t ')->getSingleResult();

        return $this->render('Nomencladores/Trazas.html.twig' , array('data' => $data));
    }

    /**
     * @Route("/insertTraza", name="insertTraza")
     */
    public function  insertTrazaAction($operacion , $descripcion)
    {
        $user = $this->getUser();

        $dataTraza = array(

            'username' => $user->getUsername(),
            'nombre' => $user->getNombre(),
            'operacion' => $operacion,
            'descripcion' => $descripcion
        );
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:Traza')-> guardarTraza($dataTraza);
    }

    /**
     * @Route("/dataTableTrazasAjax", name="dataTableTrazasAjax")
     */
    public function dataTableTrazasAjaxAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        //DataSource del DataTable
        $dql = "SELECT t FROM AppBundle:Traza t";
        $dqlTotalRecords = "SELECT count(t) FROM AppBundle:Traza t";
        $dqlCountFiltered = "SELECT count(t) FROM AppBundle:Traza t";

        $sqlFilter = "";

        if (!empty($_GET['search']['value'])) {
            $strMainSearch = $_GET['search']['value'];

            //Columnas por las que voy a permitar buscar en el datatable
            $sqlFilter .= " (t.fecha LIKE '%".$strMainSearch."%' OR "
                ."t.username LIKE '%".$strMainSearch."%' OR "
                ."t.nombre LIKE '%".$strMainSearch."%' OR "
                ."t.operacion LIKE '%".$strMainSearch."%' OR "
                ."t.descripcion LIKE '%".$strMainSearch."%') ";
        }

        // Filter columns with AND restriction
        $strColSearch = "";
        foreach ($_GET['columns'] as $column) {
            if (!empty($column['search']['value'])) {
                if (!empty($strColSearch)) {
                    $strColSearch .= ' AND ';
                }
                $strColSearch .= ' t.'.$column['name']." LIKE '%".$column['search']['value']."%'";
            }
        }
        if (!empty($sqlFilter) and !empty($strColSearch)) {
            $sqlFilter .= ' AND ('.$strColSearch.')';
        } else {
            $sqlFilter .= $strColSearch;
        }

        if (!empty($sqlFilter)) {
            if(strpos($dql , 'WHERE'))
            {
                $dql .= ' AND'.$sqlFilter;
                $dqlCountFiltered .= ' AND'.$sqlFilter;
            }else{
                $dql .= ' WHERE'.$sqlFilter;
                $dqlCountFiltered .= ' WHERE'.$sqlFilter;
            }
        }
        //Ejecucion del dql
        $items = $entityManager
            ->createQuery($dql)
            ->setFirstResult($_GET['start'])
            ->setMaxResults($_GET['length'])
            ->getResult();

       //Armar el arreglo data con el resltado del dql
        $data = array();
        foreach ($items as $key => $value) {
            $data[] = array(
                $value->getFecha()->format('Y-m-d h:s'),
                $value->getUsername(),
                $value->getNombre(),
                $value->getOperacion(),
                $value->getDescripcion(),
            );
        }

        $recordsTotal = $entityManager
            ->createQuery($dqlTotalRecords)
            ->getSingleScalarResult();

        $recordsFiltered = $entityManager
            ->createQuery($dqlCountFiltered)
            ->getSingleScalarResult();

        $output = array(
            'draw' => 0,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'dql' => $dql,
            'dqlCountFiltered' => $dqlCountFiltered,
        );

        return new JsonResponse($output);
    }

}
