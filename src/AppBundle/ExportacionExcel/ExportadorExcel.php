<?php

namespace AppBundle\ExportacionExcel;


use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExportadorExcel
{

    public function exportarDatosFormat($titulo, $subtitulo, $encabezados, $valores, $nombres)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->
        getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy($nombres)
            ->setTitle($titulo)
            ->setSubject($subtitulo)
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("NOMENCLADORES");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $titulo);

        $estiloCampos = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '#222222'
                )
            ),
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
            ],
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloCampos1 = [
            'font' => [
                'strikethrough' => true,
                'superscript' => true,
                'subscript' => true,
            ],
            'alignment' => [
                'textRotation' => 0,
                'readOrder' => Alignment::READORDER_RTL,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
        ];

        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($estiloCampos);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');


        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $subtitulo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;
    }

    public function exportarDatosNomencladores($titulo, $subtitulo, $encabezados, $valores, $nombres)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->
        getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy($nombres)
            ->setTitle($titulo)
            ->setSubject($subtitulo)
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("NOMENCLADORES");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $titulo);

        $i = 2;
        $lastColumn = 'A';
        $fila = $i + 2;
        $i = 1;

        foreach ($valores[0] as $clave => $valor) {

            $dato = $clave;

            if ($clave === 'division') $dato = 'División';
            if ($clave === 'codigo') $dato = 'Código';
            if ($clave === 'centro') $dato = 'Centro de Costo';
            if ($clave === 'denominador') $dato = 'Denominador de Cargo';
            if ($clave === 'escala') $dato = 'Grupo de Escala';
            if ($clave === 'categoria') $dato = 'Categoría';
            if ($clave === 'nombre') $dato = 'Descripción';
            if ($clave === 'activo') $dato = 'No. Activo Fijo';
            if ($clave === 'modelo') $dato = 'Marca - Modelo';
            if ($clave === 'tipo') $dato = 'Tipo de Combustible';
            if ($clave === 'tipoTransporte') $dato = 'Tipo de Transporte';
            if ($clave === 'year') $dato = 'Año';
            if ($clave === 'matricula') $dato = 'Matrícula';
            if ($clave === 'circulacion') $dato = 'Circulación';
            if ($clave === 'isServicio') $dato = 'Servicio';

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $fila, $dato);
            if ($i != count($valores[0])) $lastColumn++;
            $i++;
        }

        $cadena = $lastColumn;
        $cadena .= $fila;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':' . $cadena)->applyFromArray($this->estiloEncabezadosColumnas());

        $fila++;
        $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, $fila);

        $inicioInfo = $fila;

        foreach ($valores as $valor) {

            $column = 1;

            foreach ($valor as $clave => $value) {

                $dato = $value;

                if ($clave === 'isServicio') {
                    $dato = $dato === true ? 'SI' : 'NO';
                }

                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($column, $fila, $dato);
                $column++;
            }
            $fila++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $lastColumn . '1')->applyFromArray($this->estiloTituloReporte());

        $cadena = $lastColumn;
        $cadena .= ($fila - 1);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $inicioInfo . ':' . $cadena)->applyFromArray($this->estiloDatos());

        for ($j = 'A'; $j <= $lastColumn; $j++) {
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setAutoSize(true);
        }
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $lastColumn . '1');

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setTitle('Nomenclador');

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $subtitulo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;
    }

    public function exportarPlantillaTransporte($divisionesCentrosCostos, $tiposModelo, $transportes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plantilla Transportes")
            ->setSubject("Plantilla Transportes")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de ligeros
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B4', 'TOTALES DEL TRANSPORTE ECODIC');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'TIPO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'MARCA - MODELO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'CANTIDAD');

        $fila = 7;

        $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0, $fila);

        $tipoTransporte = $tiposModelo[0]['tipo'];
        $subTotalTipoEncabezado = '';
        $subTotalTipo = 0;
        $totalTipo = 0;
        $inicioFila = $fila;
        $finFila = 0;

        //Contenido
        foreach ($tiposModelo as $tipo) {
            if ($tipoTransporte === $tipo['tipo']) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $tipo['tipo']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $tipo['modelo']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $tipo['cantidad']);
            } else {
                $finFila = $fila - 1;
                $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $inicioFila . ':B' . $finFila);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $inicioFila . ':B' . $finFila)->applyFromArray($this->estiloCenter());
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Sub. Total ' . $subTotalTipoEncabezado);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':D' . $fila)->applyFromArray($this->estiloNegritas());
                $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':C' . $fila);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $subTotalTipo);
                $subTotalTipo = 0;
                $fila++;
                $inicioFila = $fila;
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $tipo['tipo']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $tipo['modelo']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $tipo['cantidad']);
                $tipoTransporte = $tipo['tipo'];
            }

            $subTotalTipoEncabezado = $tipo['tipo'];
            $subTotalTipo += $tipo['cantidad'];
            $totalTipo += $tipo['cantidad'];

            $fila++;
        }
        //Total de tipos de auto
        $finFila = $fila - 1;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $inicioFila . ':B' . $finFila);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $inicioFila . ':B' . $finFila)->applyFromArray($this->estiloCenter());
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Sub. Total ' . $subTotalTipoEncabezado);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':D' . $fila)->applyFromArray($this->estiloNegritas());
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':C' . $fila);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $subTotalTipo);
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total Ligeros');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':D' . $fila)->applyFromArray($this->estiloNegritas());
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':C' . $fila);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalTipo);

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('B4:D4')->applyFromArray($this->estiloTituloReporte());
        $objPHPExcel->getActiveSheet()->getStyle('B6:D6')->applyFromArray($this->estiloEncabezadosColumnas());
        for ($i = 'B'; $i <= 'D'; $i++) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(30);
        }
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B7:B10');
        $objPHPExcel->getActiveSheet()->getStyle('B7:D' . $fila)->applyFromArray($this->estiloBordes());
        //Fin del formato

        $objPHPExcel->getActiveSheet()->setTitle('LIGEROS');

        //Fin del codigo de la hoja de ligeros

        $inicioCentroCosto = true;

        //inicio del codigo que crea las hojas por cada division
        foreach ($divisionesCentrosCostos as $division) {
            $objPHPExcel->createSheet();
            $activeSheet++;
            $objPHPExcel->setActiveSheetIndex($activeSheet);

            //Titulo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B4', 'EMPLANTILLAMIENTO Y REGISTRO DE LOS MEDIOS DE TRANSPORTES DE LA ' . strtoupper($division->getNombre()));

            //Encabezados
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'NO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TIPO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'ACTIVO FIJO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'MARCA - MODELO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'AÑO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'VALOR');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'COLOR');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'MATRÍCULA');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'CHASIS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'MOTOR');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'COMBUSTIBLE');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'LUBRICANTE');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'CIRCULACIÓN');

            $fila = 7;

            $objPHPExcel->getActiveSheet($activeSheet)->freezePane('D' . $fila);
            $inicioFila = 1;
            $centroCosto = $transportes[0]['centro'];

            //Contenido
            foreach ($transportes as $transporte) {
                $pos = true;
                if ($division->getNombre() === $transporte['division']) {
                    if ($centroCosto === $transporte['centro']) {
                        if ($inicioCentroCosto) {
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $centroCosto);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':N' . $fila);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':N' . $fila)->applyFromArray($this->estiloCenter());
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':N' . $fila)->applyFromArray($this->estiloNegritas());
                            $fila++;
                            $inicioCentroCosto = false;
                        }
                        if (!$pos) {
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $transporte['centro']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':N' . $fila);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':N' . $fila)->applyFromArray($this->estiloCenter());
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':N' . $fila)->applyFromArray($this->estiloNegritas());
                            $fila++;
                        }
                        $pos = false;
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $transporte['centro']);
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':N' . $fila);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':N' . $fila)->applyFromArray($this->estiloCenter());
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':N' . $fila)->applyFromArray($this->estiloNegritas());
                        $fila++;
                        $centroCosto = $transporte['centro'];
                        $pos = true;
                    }
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $inicioFila++);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $transporte['tipo']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $transporte['activo']);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $fila . ':D' . $fila)->applyFromArray($this->estiloCenter());
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $transporte['modelo']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $transporte['year']);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $fila . ':F' . $fila)->applyFromArray($this->estiloCenter());
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $transporte['valor']);
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $transporte['Color']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $transporte['matricula']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $transporte['Chasis']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $transporte['Motor']);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $fila . ':K' . $fila)->applyFromArray($this->estiloCenter());
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $transporte['tipoCombustible']);
                    if ($transporte['lubricante']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, 'SI');
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, 'NO');
                    }
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $transporte['circulacion']);
                    $objPHPExcel->getActiveSheet()->getStyle('M' . $fila . ':N' . $fila)->applyFromArray($this->estiloCenter());
                    $fila++;
                }

            }


            //Formato de la hoja
            $objPHPExcel->getActiveSheet()->getStyle('B4:N4')->applyFromArray($this->estiloTituloReporte());
            $objPHPExcel->getActiveSheet()->getStyle('B6:N6')->applyFromArray($this->estiloEncabezadosColumnas());
            for ($i = 'B'; $i <= 'N'; $i++) {
                if ($i === 'B') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(5);
                } elseif ($i === 'L') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(25);
                } elseif ($i === 'C' || $i === 'F' || $i === 'G') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(15);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(22);
                }
            }
            $fila--;
            $objPHPExcel->getActiveSheet()->getStyle('B7:N' . $fila)->applyFromArray($this->estiloBordes());
            //Fin del formato

            $objPHPExcel->getActiveSheet()->setTitle($division->getNombre());
        }

        //fin del codigo que crea las hojas por cada division


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plantilla de Transportes.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlantillaCargo($totalCargos, $year, $divisionesCentrosCostos, $cargos)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESTCOST")
            ->setTitle("Plantilla Cargos")
            ->setSubject("Plantilla Cargos")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B3', 'TOTALES DE CARGOS APROBADOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B4', 'EMPRESA ECODIC');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B5', $year);

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B7', 'NO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C7', 'CÓDIGO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D7', 'DENOMINACIÓN DEL CARGO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E7', 'GRUPO ESCALA');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F7', 'CATEGORÍA');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G7', 'SALARIO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H7', 'APROBADA');


        $fila = 8;

        $objPHPExcel->getActiveSheet(0)->freezePane('D' . $fila);

        $totalAprobados = 0;
        $totalSalario = 0;
        $inicioFila = 1;

        //Contenido
        foreach ($totalCargos as $cargo) {

            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $inicioFila++);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $cargo['codigo']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $cargo['denominador']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $cargo['escala']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $cargo['categoria']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $cargo['salario']);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila . ':G' . $fila)->applyFromArray($this->estiloCenter());
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $cargo['aprobada']);

            $totalAprobados += $cargo['aprobada'];
            $totalSalario += $cargo['salario'];

            $fila++;
        }
        //Total de cargos
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloNegritas());
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':F' . $fila);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $totalSalario);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalAprobados);

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('B3:H3')->applyFromArray($this->estiloTituloReporte());
        $objPHPExcel->getActiveSheet()->getStyle('B4:H4')->applyFromArray($this->estiloTituloReporte());
        $objPHPExcel->getActiveSheet()->getStyle('B5:H5')->applyFromArray($this->estiloTituloReporte());
        $objPHPExcel->getActiveSheet()->getStyle('B7:H7')->applyFromArray($this->estiloEncabezadosColumnas());
        for ($i = 'B'; $i <= 'H'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(5);
            } else if ($i === 'D') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(70);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(22);
            }
        }

        $objPHPExcel->getActiveSheet()->getStyle('B8:H' . $fila)->applyFromArray($this->estiloBordes());
        //Fin del formato

        $objPHPExcel->getActiveSheet()->setTitle('TOTALES');

        //Fin del codigo de la hoja de totales

        $inicioCentroCosto = true;

        //inicio del codigo que crea las hojas por cada division
        foreach ($divisionesCentrosCostos as $division) {
            $objPHPExcel->createSheet();
            $activeSheet++;
            $objPHPExcel->setActiveSheetIndex($activeSheet);

            //Titulo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B3', 'MODELO P-2 : PLANTILLA DE CARGOS  AÑO ' . $year);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B4', strtoupper($division->getNombre()));

            //Encabezados
            //Encabezados
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B7', 'NO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C7', 'CÓDIGO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D7', 'DENOMINACIÓN DEL CARGO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E7', 'GRUPO ESCALA');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F7', 'CATEGORÍA');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G7', 'SALARIO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H7', 'APROBADA');

            $fila = 8;

            $objPHPExcel->getActiveSheet(0)->freezePane('D' . $fila);

            $inicioFila = 1;
            $centroCosto = $cargos[0]['centro'];
            $subTotalCentroCosto = 0;
            $subTotalSalario = 0;
            $totalSalario = 0;
            $totalDivision = 0;

            //Contenido
            foreach ($cargos as $cargo) {
                $pos = true;
                if ($division->getNombre() === $cargo['division']) {
                    if ($centroCosto === $cargo['centro']) {
                        if ($inicioCentroCosto) {
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $centroCosto);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':H' . $fila);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloCenter());
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloNegritas());
                            $fila++;
                            $inicioCentroCosto = false;
                        }
                        if (!$pos) {
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $cargo['centro']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':F' . $fila);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloCenter());
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloNegritas());
                            $subTotalCentroCosto = 0;
                            $subTotalSalario = 0;
                            $fila++;
                        }
                        $pos = false;
                    } else {
                        if ($subTotalCentroCosto !== 0) {
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Sub. Total');
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloNegritas());
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':F' . $fila);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $subTotalSalario);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $subTotalCentroCosto);
                            $fila++;
                        }
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $cargo['centro']);
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':H' . $fila);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloCenter());
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloNegritas());
                        $subTotalCentroCosto = 0;
                        $subTotalSalario = 0;
                        $fila++;
                        $centroCosto = $cargo['centro'];
                        $pos = true;
                    }
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $inicioFila++);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $cargo['codigo']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $cargo['denominador']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $cargo['escala']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $cargo['categoria']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $cargo['salario']);
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $fila . ':G' . $fila)->applyFromArray($this->estiloCenter());
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $cargo['aprobada']);

                    $subTotalCentroCosto += $cargo['aprobada'];
                    $subTotalSalario += $cargo['salario'];
                    $totalDivision += $cargo['aprobada'];
                    $totalSalario += $cargo['salario'];

                    $fila++;
                }

            }
            //Total de cargos
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Sub. Total');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloNegritas());
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':F' . $fila);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $subTotalSalario);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $subTotalCentroCosto);
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':H' . $fila)->applyFromArray($this->estiloNegritas());
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':F' . $fila);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $totalSalario);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalDivision);


            //Formato de la hoja
            $objPHPExcel->getActiveSheet()->getStyle('B3:H3')->applyFromArray($this->estiloTituloReporte());
            $objPHPExcel->getActiveSheet()->getStyle('B4:H4')->applyFromArray($this->estiloTituloReporte());
            $objPHPExcel->getActiveSheet()->getStyle('B7:H7')->applyFromArray($this->estiloEncabezadosColumnas());
            for ($i = 'B'; $i <= 'H'; $i++) {
                if ($i === 'B') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(5);
                } else if ($i === 'D') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(70);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(22);
                }
            }

            $objPHPExcel->getActiveSheet()->getStyle('B7:H' . $fila)->applyFromArray($this->estiloBordes());
            //Fin del formato

            $objPHPExcel->getActiveSheet()->setTitle($division->getNombre());
        }

        //fin del codigo que crea las hojas por cada division


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plantilla de Cargos.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoCombustibleDivision($totalTransportes, $year, $totalMesTransportes, $divisionesCentrosCostos)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado del Combustible por divisiones")
            ->setSubject("Plan Estimado del Combustible por divisiones")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B3', 'PLAN ESTIMADO ' . $year . ' DEL COMBUSTIBLE POR DIVISIONES');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B4', 'EMPRESA ECODIC');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'PRODUCTO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'LTS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'PRECIO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'IMPORTE');


        $inicioDivision = true;

        $fila = 7;
        $centroCosto = $totalTransportes[0]['division'];
        $subTotalLTS = 0;
        $subTotalImporte = 0;
        $totalLTS = 0;
        $totalImporte = 0;


        //Contenido
        foreach ($totalTransportes as $transporte) {
            $pos = true;
            if ($centroCosto === $transporte['division']) {
                if ($inicioDivision) {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $centroCosto);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':E' . $fila);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloCenter());
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloNegritas());
                    $fila++;
                    $inicioDivision = false;
                }
                if (!$pos) {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $transporte['division']);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':E' . $fila);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloCenter());
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloNegritas());
                    $subTotalLTS = 0;
                    $subTotalImporte = 0;
                    $fila++;
                }
                $pos = false;
            } else {
                if ($subTotalLTS !== 0) {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Sub. Total');
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloNegritas());
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $subTotalLTS);
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $subTotalImporte);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $fila++;
                }
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $transporte['division']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B' . $fila . ':E' . $fila);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloCenter());
                $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloNegritas());
                $subTotalLTS = 0;
                $subTotalImporte = 0;
                $fila++;
                $centroCosto = $transporte['division'];
                $pos = true;
            }

            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $transporte['tipoCombustible']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $transporte['lts']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $transporte['precio']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $transporte['importe']);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

            $subTotalLTS += $transporte['lts'];
            $totalLTS += $transporte['lts'];
            $subTotalImporte += $transporte['importe'];
            $totalImporte += $transporte['importe'];

            $fila++;
        }

        //Total de cargos
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Sub. Total');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloNegritas());
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $subTotalLTS);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $subTotalImporte);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':E' . $fila)->applyFromArray($this->estiloNegritas());
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalLTS);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $totalImporte);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');


        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('B3:E3')->applyFromArray($this->estiloTituloReporte());
        $objPHPExcel->getActiveSheet()->getStyle('B4:E4')->applyFromArray($this->estiloTituloReporte());
        $objPHPExcel->getActiveSheet()->getStyle('B6:E6')->applyFromArray($this->estiloEncabezadosColumnas());

        for ($i = 'B'; $i <= 'E'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(25);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(15);
            }
        }

        $objPHPExcel->getActiveSheet()->getStyle('B7:E' . $fila)->applyFromArray($this->estiloBordes());
        //Fin del formato

        $objPHPExcel->getActiveSheet()->setTitle('TOTALES');

        //Fin del codigo de la hoja de totales


        //inicio del codigo que crea las hojas por cada division

        foreach ($divisionesCentrosCostos as $division) {
            $objPHPExcel->createSheet();
            $activeSheet++;
            $objPHPExcel->setActiveSheetIndex($activeSheet);

            //Titulo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B3', 'PLAN ESTIMADO MENSUAL DEL COMBUSTIBLE EN LA ' . strtoupper($division->getNombre()));
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B4', 'EMPRESA ECODIC');

            //Encabezados
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'PRODUCTO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'Enero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:D6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:F6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Marzo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:H6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Abril');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:J6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Mayo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:L6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Junio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:N6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Julio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:P6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q6', 'Agosto');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Q6:R6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S6', 'Septiembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('S6:T6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U6', 'Octubre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('U6:V6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W6', 'Noviembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('W6:X6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X7', 'IMP');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y6', 'Diciembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Y6:Z6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y7', 'LTS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z7', 'IMP');


            $fila = 8;
            $totalLTSEnero = 0;
            $totalImporteEnero = 0;
            $totalLTSFebrero = 0;
            $totalImporteFebrero = 0;
            $totalLTSMarzo = 0;
            $totalImporteMarzo = 0;
            $totalLTSAbril = 0;
            $totalImporteAbril = 0;
            $totalLTSMayo = 0;
            $totalImporteMayo = 0;
            $totalLTSJunio = 0;
            $totalImporteJunio = 0;
            $totalLTSJulio = 0;
            $totalImporteJulio = 0;
            $totalLTSAgosto = 0;
            $totalImporteAgosto = 0;
            $totalLTSSeptiembre = 0;
            $totalImporteSeptiembre = 0;
            $totalLTSOctubre = 0;
            $totalImporteOctubre = 0;
            $totalLTSNoviembre = 0;
            $totalImporteNoviembre = 0;
            $totalLTSDiciembre = 0;
            $totalImporteDiciembre = 0;

            //Obtener el primer value de tipo de combustible
            foreach ($totalMesTransportes as $transporte) {
                if ($division->getNombre() === $transporte['division']) {
                    $tipoCombustible = $transporte['tipoCombustible'];
                    break;
                }
            }

            //Contenido
            foreach ($totalMesTransportes as $transporte) {
                if ($division->getNombre() === $transporte['division']) {
                    if ($tipoCombustible === $transporte['tipoCombustible']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $transporte['tipoCombustible']);
                    } else {
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $transporte['tipoCombustible']);
                    }
                    $tipoCombustible = $transporte['tipoCombustible'];
                    switch ($transporte['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSEnero += $transporte['ltsMes'];
                            $totalImporteEnero += $transporte['importeMes'];
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSFebrero += $transporte['ltsMes'];
                            $totalImporteFebrero += $transporte['importeMes'];
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSMarzo += $transporte['ltsMes'];
                            $totalImporteMarzo += $transporte['importeMes'];
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSAbril += $transporte['ltsMes'];
                            $totalImporteAbril += $transporte['importeMes'];
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSMayo += $transporte['ltsMes'];
                            $totalImporteMayo += $transporte['importeMes'];
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSJunio += $transporte['ltsMes'];
                            $totalImporteJunio += $transporte['importeMes'];
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSJulio += $transporte['ltsMes'];
                            $totalImporteJulio += $transporte['importeMes'];
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSAgosto += $transporte['ltsMes'];
                            $totalImporteAgosto += $transporte['importeMes'];
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSSeptiembre += $transporte['ltsMes'];
                            $totalImporteSeptiembre += $transporte['importeMes'];
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSOctubre += $transporte['ltsMes'];
                            $totalImporteOctubre += $transporte['importeMes'];
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSNoviembre += $transporte['ltsMes'];
                            $totalImporteNoviembre += $transporte['importeMes'];
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $transporte['ltsMes']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $transporte['importeMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalLTSDiciembre += $transporte['ltsMes'];
                            $totalImporteDiciembre += $transporte['importeMes'];
                            break;
                    }
                }
            }


            $fila++;

            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total');
            //enero
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalLTSEnero);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteEnero);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //febrero
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $totalLTSFebrero);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $totalImporteFebrero);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //marzo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $totalLTSMarzo);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalImporteMarzo);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //abril
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $totalLTSAbril);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $totalImporteAbril);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //mayo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $totalLTSMayo);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $totalImporteMayo);
            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //junio
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $totalLTSJunio);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $totalImporteJunio);
            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //julio
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $totalLTSJulio);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $totalImporteJulio);
            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //agosto
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $totalLTSAgosto);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $totalImporteAgosto);
            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //septiembre
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $totalLTSSeptiembre);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $totalImporteSeptiembre);
            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //octubre
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $totalLTSOctubre);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $totalImporteOctubre);
            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //noviembre
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $totalLTSNoviembre);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $totalImporteNoviembre);
            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            //diciembre
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $totalLTSDiciembre);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $totalImporteDiciembre);
            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':Z' . $fila)->applyFromArray($this->estiloNegritas());


            //Formato de la hoja
            $objPHPExcel->getActiveSheet()->getStyle('B3:Q4')->applyFromArray($this->estiloTituloReporte());
            $objPHPExcel->getActiveSheet()->getStyle('B6:Z7')->applyFromArray($this->estiloEncabezadosColumnasMenor());
            $objPHPExcel->getActiveSheet()->getStyle('B6:Z7')->applyFromArray($this->estiloCenter());
            for ($i = 'B'; $i <= 'Z'; $i++) {
                if ($i === 'B') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(25);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(10);
                }
            }
            /*$fila--;*/

            $objPHPExcel->getActiveSheet()->getStyle('B8:Z' . $fila)->applyFromArray($this->estiloBordes());
            //Fin del formato

            $objPHPExcel->getActiveSheet()->setTitle($division->getNombre());
        }

        //fin del codigo que crea las hojas por cada division


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Combustible Division.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoVentaDivision($year, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoCentroCostoMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Ventas por divisiones")
            ->setSubject("Plan Estimado de Ventas por divisiones")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PROPUESTA  DEL PLAN DE VENTAS ' . $year . ' POR GRUPOS DE DISEÑO');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');

        for ($i = 'D'; $i <= 'O'; $i++) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '7', 'Mes');
        }

        $objPHPExcel->getActiveSheet(0)->freezePane('D8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'O'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
            } elseif ($i === 'C') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Contenido
        $fila = 8;
        $centroCosto = '';

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }
        }

        $fila--;
        $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('PROPUESTA PLAN ' . $year . ' POR GRUPOS');

        //Fin del codigo de la hoja de totales

        //Por divisiones
        foreach ($divisionesCentrosCostos as $division) {
            $objPHPExcel->createSheet();
            $activeSheet++;
            $objPHPExcel->setActiveSheetIndex($activeSheet);

            //titulo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PROPUESTA  DEL PLAN DE VENTAS ' . $year . ' ' . strtoupper($division['division']));

            //Encabezados
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');

            for ($i = 'D'; $i <= 'O'; $i++) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '7', 'Mes');
            }

            /* $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(4, 8);*/
            $objPHPExcel->getActiveSheet(0)->freezePane('D8');

            //Formato de la hoja
            $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
            $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

            for ($i = 'B'; $i <= 'O'; $i++) {
                if ($i === 'B') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(25);
                } elseif ($i === 'C') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
                }
            }

            //Contenido
            $fila = 8;
            $centroCosto = '';

            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }

            $fila--;
            $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());

            $objPHPExcel->getActiveSheet()->setTitle($division['division']);

        }

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Ventas Division.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoVentaCentroCosto($year, $divisionCentroCosto, $presupuestoDivisionesMes, $presupuestoCentroCostoMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Ventas por centro de costo")
            ->setSubject("Plan Estimado de Ventas por centro de costo")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PROPUESTA  DEL PLAN DE VENTAS ' . $year . ' ' . strtoupper($divisionCentroCosto));

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');

        for ($i = 'D'; $i <= 'O'; $i++) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '7', 'Mes');
        }

        /* $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(4, 8);*/
        $objPHPExcel->getActiveSheet(0)->freezePane('D8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'O'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(30);
            } elseif ($i === 'C') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Contenido
        $fila = 8;
        $centroCosto = '';

        //Obtener el primer value de centro de costo de esta division
        foreach ($presupuestoCentroCostoMes as $presupuesto) {
            if ($divisionCentroCosto === $presupuesto['division']) {
                $centroCosto = $presupuesto['centro'];
                break;
            }
        }
        //Division
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $divisionCentroCosto);
        foreach ($presupuestoDivisionesMes as $presupuesto) {
            if ($divisionCentroCosto === $presupuesto['division']) {
                switch ($presupuesto['mes']) {
                    case 'enero':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'febrero':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'marzo':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'abril':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'mayo':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'junio':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'julio':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'agosto':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'septiembre':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'octubre':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'noviembre':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'diciembre':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                }
            }
        }
        //Totales
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
        $fila++;
        $existe = false;
        //Centro de Costo de la division
        foreach ($presupuestoCentroCostoMes as $presupuesto) {
            if ($divisionCentroCosto === $presupuesto['division']) {
                $existe = true;
                if ($centroCosto === $presupuesto['centro']) {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                }
                $centroCosto = $presupuesto['centro'];

                switch ($presupuesto['mes']) {
                    case 'enero':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'febrero':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'marzo':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'abril':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'mayo':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'junio':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'julio':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'agosto':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'septiembre':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'octubre':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'noviembre':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                    case 'diciembre':
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                        $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        break;
                }
            }
        }
        //Totales
        if ($existe) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $fila++;
        }

        $fila--;
        $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('PROPUESTA PLAN ' . $year . ' DIVISION');

        //Fin del codigo de la hoja de totales

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Ventas Centro Costo.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoFondoSalario($year, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoDivisionesMesVenta, $presupuestoCentroCostoMes, $presupuestoCentrosCostosMesVenta)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Recursos Humanos")
            ->setSubject("Plan Estimado de Recursos Humanos")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B1', 'DESAGREGACION DEL FONDO DE SALARIO POR MESES Y CENTROS DE COSTO DEL AÑO ' . $year);

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A2', 'GRUPO/TALLERES');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('A2:A3');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B2', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B2:F2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G2', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G2:K2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L2', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('L2:P2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q2', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Q2:U2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V2', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('V2:Z2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA2', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AA2:AE2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AC3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AD3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AE3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AF2', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AF2:AJ2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AF3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AG3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AH3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AI3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AJ3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AK2', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AK2:AO2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AK3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AL3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AM3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AN3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AO3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AP2', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AP2:AT2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AP3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AQ3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AR3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AS3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AT3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AU2', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AU2:AY2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AU3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AV3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AW3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AX3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AY3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AZ2', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AZ2:BD2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AZ3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BA3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BB3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BC3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BD3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BE2', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('BE2:BI2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BE3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BF3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BG3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BH3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BI3', 'SM');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BJ2', 'Total');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('BJ2:BN2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BJ3', 'PROD.');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BK3', 'FS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BL3', 'GSXPP');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BM3', 'PT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BN3', 'SM');

        $objPHPExcel->getActiveSheet(0)->freezePane('B4');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('B1:T1')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('A2:BN3')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'A'; $i <= 'Z'; $i++) {
            if ($i === 'A') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(25);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            }
        }

        //Contenido
        $fila = 4;
        $centroCosto = '';
        $totalDivisionVentaEnero = 0;
        $totalDivisionVentaFebrero = 0;
        $totalDivisionVentaMarzo = 0;
        $totalDivisionVentaAbril = 0;
        $totalDivisionVentaMayo = 0;
        $totalDivisionVentaJunio = 0;
        $totalDivisionVentaJulio = 0;
        $totalDivisionVentaAgosto = 0;
        $totalDivisionVentaSeptiembre = 0;
        $totalDivisionVentaOctubre = 0;
        $totalDivisionVentaNoviembre = 0;
        $totalDivisionVentaDiciembre = 0;

        $fondoDivisionEnero = 0;
        $fondoDivisionFebrero = 0;
        $fondoDivisionMarzo = 0;
        $fondoDivisionAbril = 0;
        $fondoDivisionMayo = 0;
        $fondoDivisionJunio = 0;
        $fondoDivisionJulio = 0;
        $fondoDivisionAgosto = 0;
        $fondoDivisionSeptiembre = 0;
        $fondoDivisionOctubre = 0;
        $fondoDivisionNoviembre = 0;
        $fondoDivisionDiciembre = 0;

        $promedioDivisionEnero = 0;
        $promedioDivisionFebrero = 0;
        $promedioDivisionMarzo = 0;
        $promedioDivisionAbril = 0;
        $promedioDivisionMayo = 0;
        $promedioDivisionJunio = 0;
        $promedioDivisionJulio = 0;
        $promedioDivisionAgosto = 0;
        $promedioDivisionSeptiembre = 0;
        $promedioDivisionOctubre = 0;
        $promedioDivisionNoviembre = 0;
        $promedioDivisionDiciembre = 0;

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':BN' . $fila)->applyFromArray($this->estiloNegritas());

            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('B' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaEnero += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionEnero += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionEnero += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'febrero':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaFebrero += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionFebrero += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionFebrero += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'marzo':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaMarzo += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionMarzo += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionMarzo += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'abril':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaAbril += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('S' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('U' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionAbril += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionAbril += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'mayo':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaMayo += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('W' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionMayo += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionMayo += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'junio':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaJunio += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AC' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AC' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AD' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AD' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AE' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AE' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionJunio += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionJunio += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'julio':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AF' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AF' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaJulio += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AG' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AG' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AH' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AH' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AI' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AI' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AJ' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AJ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionJulio += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionJulio += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'agosto':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AK' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AK' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaAgosto += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AL' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AL' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AM' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AM' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AN' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AN' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AO' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AO' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionAgosto += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionAgosto += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'septiembre':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AP' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AP' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaSeptiembre += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AQ' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AQ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AR' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AR' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AS' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AS' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AT' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AT' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionSeptiembre += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionSeptiembre += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'octubre':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AU' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AU' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaOctubre += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AV' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AV' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AW' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AW' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AX' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AX' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AY' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AY' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionOctubre += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionOctubre += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'noviembre':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AZ' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AZ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaNoviembre += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BA' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BB' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BB' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BC' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BC' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BD' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BD' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionNoviembre += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionNoviembre += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                        case 'diciembre':
                            //ventas
                            foreach ($presupuestoDivisionesMesVenta as $venta) {
                                if (($presupuesto['division'] === $venta['division']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BE' . $fila, $venta['totalVentaDivisionMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('BE' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    $totalDivisionVentaDiciembre += (int)$venta['totalVentaDivisionMes'];
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BF' . $fila, $presupuesto['totalSalarioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BF' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BG' . $fila, $presupuesto['totalGastoSalarioPesoProduccionDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BG' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BH' . $fila, $presupuesto['totalPromedioTrabajadorMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BH' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BI' . $fila, $presupuesto['totalSalarioMedioDivisionMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BI' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fondoDivisionDiciembre += (int)$presupuesto['totalSalarioDivisionMes'];
                            $promedioDivisionDiciembre += (int)$presupuesto['totalPromedioTrabajadorMes'];
                            break;
                    }
                }
            }
            // Sub Totales por fila
            //total de ventas
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BJ' . $fila, '=B' . $fila . '+G' . $fila . '+L' . $fila . '+Q' . $fila . '+V' . $fila . '+AA' . $fila . '+AF' . $fila . '+AK' . $fila . '+AP' . $fila . '+AU' . $fila . '+AZ' . $fila . '+BE' . $fila);
            $objPHPExcel->getActiveSheet()->getStyle('BJ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
            //total de fondo de salario
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BK' . $fila, '=C' . $fila . '+H' . $fila . '+M' . $fila . '+R' . $fila . '+W' . $fila . '+AB' . $fila . '+AG' . $fila . '+AL' . $fila . '+AQ' . $fila . '+AV' . $fila . '+BA' . $fila . '+BF' . $fila);
            $objPHPExcel->getActiveSheet()->getStyle('BK' . $fila)->getNumberFormat()->setFormatCode('#,##0');
            //total de GSXPP
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BL' . $fila, '=BK' . $fila . '/BJ' . $fila);
            $objPHPExcel->getActiveSheet()->getStyle('BL' . $fila)->getNumberFormat()->setFormatCode('#,##0');
            //total de promedio de trabajo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BM' . $fila, '=(E' . $fila . '+J' . $fila . '+O' . $fila . '+T' . $fila . '+Y' . $fila . '+AD' . $fila . '+AI' . $fila . '+AN' . $fila . '+AS' . $fila . '+AX' . $fila . '+BC' . $fila . '+BH' . $fila . ')/12');
            $objPHPExcel->getActiveSheet()->getStyle('BM' . $fila)->getNumberFormat()->setFormatCode('#,##0');
            //total de salario medio
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BN' . $fila, '=(BK' . $fila . '/BM' . $fila . ')/12');
            $objPHPExcel->getActiveSheet()->getStyle('BN' . $fila)->getNumberFormat()->setFormatCode('#,##0');

            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, $presupuesto['centro']);
                    } else {
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('B' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('S' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('U' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('W' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AC' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AC' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AD' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AD' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AE' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AE' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AF' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AF' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AG' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AG' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AH' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AH' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AI' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AI' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AJ' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AJ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AK' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AK' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AL' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AL' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AM' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AM' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AN' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AN' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AO' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AO' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AP' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AP' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AQ' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AQ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AR' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AR' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AS' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AS' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AT' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AT' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AU' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AU' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AV' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AV' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AW' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AW' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AX' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AX' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AY' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('AY' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AZ' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('AZ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BA' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BB' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BB' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BC' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BC' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BD' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BD' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            //ventas
                            foreach ($presupuestoCentrosCostosMesVenta as $venta) {
                                if (($centroCosto === $venta['centro']) && $presupuesto['mes'] === $venta['mes']) {
                                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BE' . $fila, $venta['totalVentaCentroCostoMes']);
                                    $objPHPExcel->getActiveSheet()->getStyle('BE' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                                    break;
                                }
                            }
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BF' . $fila, $presupuesto['totalSalarioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BF' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BG' . $fila, $presupuesto['totalGastoSalarioPesoProduccionCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BG' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BH' . $fila, $presupuesto['totalPromedioTrabajadorCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BH' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BI' . $fila, $presupuesto['totalSalarioMedioCentroCostoMes']);
                            $objPHPExcel->getActiveSheet()->getStyle('BI' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                    // Sub Totales por fila
                    //total de ventas
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BJ' . $fila, '=B' . $fila . '+G' . $fila . '+L' . $fila . '+Q' . $fila . '+V' . $fila . '+AA' . $fila . '+AF' . $fila . '+AK' . $fila . '+AP' . $fila . '+AU' . $fila . '+AZ' . $fila . '+BE' . $fila);
                    $objPHPExcel->getActiveSheet()->getStyle('BJ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    //total de fondo de salario
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BK' . $fila, '=C' . $fila . '+H' . $fila . '+M' . $fila . '+R' . $fila . '+W' . $fila . '+AB' . $fila . '+AG' . $fila . '+AL' . $fila . '+AQ' . $fila . '+AV' . $fila . '+BA' . $fila . '+BF' . $fila);
                    $objPHPExcel->getActiveSheet()->getStyle('BK' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    //total de GSXPP
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BL' . $fila, '=BK' . $fila . '/BJ' . $fila);
                    $objPHPExcel->getActiveSheet()->getStyle('BL' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    //total de promedio de trabajo
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BM' . $fila, '=(E' . $fila . '+J' . $fila . '+O' . $fila . '+T' . $fila . '+Y' . $fila . '+AD' . $fila . '+AI' . $fila . '+AN' . $fila . '+AS' . $fila . '+AX' . $fila . '+BC' . $fila . '+BH' . $fila . ')/12');
                    $objPHPExcel->getActiveSheet()->getStyle('BM' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    //total de salario medio
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BN' . $fila, '=(BK' . $fila . '/BM' . $fila . ')/12');
                    $objPHPExcel->getActiveSheet()->getStyle('BN' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                }
            }
            if ($existe) {
                $fila++;
            }
        }

        //Totales
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Total');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $totalDivisionVentaEnero);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $fondoDivisionEnero);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $fondoDivisionEnero / $totalDivisionVentaEnero);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $promedioDivisionEnero);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $fondoDivisionEnero / $promedioDivisionEnero);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $totalDivisionVentaFebrero);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $fondoDivisionFebrero);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $fondoDivisionFebrero / $totalDivisionVentaFebrero);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $promedioDivisionFebrero);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $fondoDivisionFebrero / $promedioDivisionFebrero);
        $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $totalDivisionVentaMarzo);
        $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $fondoDivisionMarzo);
        $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $fondoDivisionMarzo / $totalDivisionVentaMarzo);
        $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $promedioDivisionMarzo);
        $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $fondoDivisionMarzo / $promedioDivisionMarzo);
        $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $totalDivisionVentaAbril);
        $objPHPExcel->getActiveSheet()->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $fondoDivisionAbril);
        $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $fondoDivisionAbril / $totalDivisionVentaAbril);
        $objPHPExcel->getActiveSheet()->getStyle('S' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $promedioDivisionAbril);
        $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $fondoDivisionAbril / $promedioDivisionAbril);
        $objPHPExcel->getActiveSheet()->getStyle('U' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $totalDivisionVentaMayo);
        $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $fondoDivisionMayo);
        $objPHPExcel->getActiveSheet()->getStyle('W' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $fondoDivisionMayo / $totalDivisionVentaMayo);
        $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $promedioDivisionMayo);
        $objPHPExcel->getActiveSheet()->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $fondoDivisionMayo / $promedioDivisionMayo);
        $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA' . $fila, $totalDivisionVentaJunio);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $fondoDivisionJunio);
        $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AC' . $fila, $fondoDivisionJunio / $totalDivisionVentaJunio);
        $objPHPExcel->getActiveSheet()->getStyle('AC' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AD' . $fila, $promedioDivisionJunio);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AE' . $fila, $fondoDivisionJunio / $promedioDivisionJunio);
        $objPHPExcel->getActiveSheet()->getStyle('AE' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AF' . $fila, $totalDivisionVentaJulio);
        $objPHPExcel->getActiveSheet()->getStyle('AF' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AG' . $fila, $fondoDivisionJulio);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AH' . $fila, $fondoDivisionJulio / $totalDivisionVentaJulio);
        $objPHPExcel->getActiveSheet()->getStyle('AH' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AI' . $fila, $promedioDivisionJulio);
        $objPHPExcel->getActiveSheet()->getStyle('AI' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AJ' . $fila, $fondoDivisionJulio / $promedioDivisionJulio);
        $objPHPExcel->getActiveSheet()->getStyle('AJ' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AK' . $fila, $totalDivisionVentaAgosto);
        $objPHPExcel->getActiveSheet()->getStyle('AK' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AL' . $fila, $fondoDivisionAgosto);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AM' . $fila, $fondoDivisionAgosto / $totalDivisionVentaAgosto);
        $objPHPExcel->getActiveSheet()->getStyle('AM' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AN' . $fila, $promedioDivisionAgosto);
        $objPHPExcel->getActiveSheet()->getStyle('AN' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AO' . $fila, $fondoDivisionAgosto / $promedioDivisionAgosto);
        $objPHPExcel->getActiveSheet()->getStyle('AO' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AP' . $fila, $totalDivisionVentaSeptiembre);
        $objPHPExcel->getActiveSheet()->getStyle('AP' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AQ' . $fila, $fondoDivisionSeptiembre);
        $objPHPExcel->getActiveSheet()->getStyle('AQ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AR' . $fila, $fondoDivisionSeptiembre / $totalDivisionVentaSeptiembre);
        $objPHPExcel->getActiveSheet()->getStyle('AR' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AS' . $fila, $promedioDivisionSeptiembre);
        $objPHPExcel->getActiveSheet()->getStyle('AS' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AT' . $fila, $fondoDivisionSeptiembre / $promedioDivisionSeptiembre);
        $objPHPExcel->getActiveSheet()->getStyle('AT' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AU' . $fila, $totalDivisionVentaOctubre);
        $objPHPExcel->getActiveSheet()->getStyle('AU' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AV' . $fila, $fondoDivisionOctubre);
        $objPHPExcel->getActiveSheet()->getStyle('AV' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AW' . $fila, $fondoDivisionOctubre / $totalDivisionVentaOctubre);
        $objPHPExcel->getActiveSheet()->getStyle('AW' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AX' . $fila, $promedioDivisionOctubre);
        $objPHPExcel->getActiveSheet()->getStyle('AX' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AY' . $fila, $fondoDivisionOctubre / $promedioDivisionOctubre);
        $objPHPExcel->getActiveSheet()->getStyle('AY' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AZ' . $fila, $totalDivisionVentaNoviembre);
        $objPHPExcel->getActiveSheet()->getStyle('AZ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BA' . $fila, $fondoDivisionNoviembre);
        $objPHPExcel->getActiveSheet()->getStyle('BA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BB' . $fila, $fondoDivisionNoviembre / $totalDivisionVentaNoviembre);
        $objPHPExcel->getActiveSheet()->getStyle('BB' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BC' . $fila, $promedioDivisionNoviembre);
        $objPHPExcel->getActiveSheet()->getStyle('BC' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BD' . $fila, $fondoDivisionNoviembre / $promedioDivisionNoviembre);
        $objPHPExcel->getActiveSheet()->getStyle('BD' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BE' . $fila, $totalDivisionVentaDiciembre);
        $objPHPExcel->getActiveSheet()->getStyle('BE' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BF' . $fila, $fondoDivisionDiciembre);
        $objPHPExcel->getActiveSheet()->getStyle('BF' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BG' . $fila, $fondoDivisionDiciembre / $totalDivisionVentaDiciembre);
        $objPHPExcel->getActiveSheet()->getStyle('BG' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BH' . $fila, $promedioDivisionDiciembre);
        $objPHPExcel->getActiveSheet()->getStyle('BH' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BI' . $fila, $fondoDivisionDiciembre / $promedioDivisionDiciembre);
        $objPHPExcel->getActiveSheet()->getStyle('BI' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        //Totales generales
        //total de ventas
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BJ' . $fila, '=B' . $fila . '+G' . $fila . '+L' . $fila . '+Q' . $fila . '+V' . $fila . '+AA' . $fila . '+AF' . $fila . '+AK' . $fila . '+AP' . $fila . '+AU' . $fila . '+AZ' . $fila . '+BE' . $fila);
        $objPHPExcel->getActiveSheet()->getStyle('BJ' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        //total de fondo de salario
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BK' . $fila, '=C' . $fila . '+H' . $fila . '+M' . $fila . '+R' . $fila . '+W' . $fila . '+AB' . $fila . '+AG' . $fila . '+AL' . $fila . '+AQ' . $fila . '+AV' . $fila . '+BA' . $fila . '+BF' . $fila);
        $objPHPExcel->getActiveSheet()->getStyle('BK' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        //total de GSXPP
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BL' . $fila, '=BK' . $fila . '/BJ' . $fila);
        $objPHPExcel->getActiveSheet()->getStyle('BL' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        //total de promedio de trabajo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BM' . $fila, '=(E' . $fila . '+J' . $fila . '+O' . $fila . '+T' . $fila . '+Y' . $fila . '+AD' . $fila . '+AI' . $fila . '+AN' . $fila . '+AS' . $fila . '+AX' . $fila . '+BC' . $fila . '+BH' . $fila . ')/12');
        $objPHPExcel->getActiveSheet()->getStyle('BM' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        //total de salario medio
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('BN' . $fila, '=(BK' . $fila . '/BM' . $fila . ')/12');
        $objPHPExcel->getActiveSheet()->getStyle('BN' . $fila)->getNumberFormat()->setFormatCode('#,##0');

        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':BN' . $fila)->applyFromArray($this->estiloNegritas());

        $objPHPExcel->getActiveSheet()->getStyle('A2:BN' . $fila)->applyFromArray($this->estiloBordesVentas());

        $objPHPExcel->getActiveSheet()->getStyle('A2:A' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');


        $objPHPExcel->getActiveSheet()->setTitle('TOTAL ECODIC');

        //Fin del codigo de la hoja de totales

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Recursos Humanos.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoOtroGasto($year, $otrosGastos, $otrosGastosMes, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoCentroCostoMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Otros Gastos")
            ->setSubject("Plan Estimado de Otros Gastos")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PLAN ' . $year . ' DE OTROS GASTOS MONETARIOS ');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'SERVICIOS COMPRADOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');

        $objPHPExcel->getActiveSheet(0)->freezePane('D7');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:O6')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'O'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(70);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Contenido
        $fila = 7;

        //Otros Gastos
        foreach ($otrosGastos as $otro) {
            //Otros Gastos Mensuales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $otro['otroGasto']);
            foreach ($otrosGastosMes as $otroMes) {
                if ($otro['otroGasto'] === $otroMes['otroGasto']) {
                    switch ($otroMes['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $otroMes['totalOtroGasto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
            $fila++;
            $existe = false;
        }

        $final = $fila - 1;

        //Totales
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total');
        for ($i = 'C'; $i <= 'O'; $i++) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . $fila, '=SUM(' . $i . '7:' . $i . $final . ')');
            $objPHPExcel->getActiveSheet()->getStyle($i . $fila)->getNumberFormat()->setFormatCode('#,##0');
        }

        $objPHPExcel->getActiveSheet()->getStyle('B7:C' . $fila)->applyFromArray($this->estiloNegritas());
        $objPHPExcel->getActiveSheet()->getStyle('D' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());

        $existe = false;

        $objPHPExcel->getActiveSheet()->getStyle('B7:O' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('TOTALES');

        //Fin del codigo de la hoja de totales


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Otros Gastos.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoMateriaPrima($year, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoCentroCostoMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Materias Primas por divisiones")
            ->setSubject("Plan Estimado de Materias Primas por divisiones")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PROPUESTA DEL PLAN DE MATERIAS PRIMAS PARA EL AÑO ' . $year);

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('D6:D7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:E7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('F6:F7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:G7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('H6:H7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:I7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('J6:J7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:K7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('L6:L7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:M7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('N6:N7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:O7');


        $objPHPExcel->getActiveSheet(0)->freezePane('D8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'O'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(33);
            } elseif ($i === 'C') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Contenido
        $fila = 8;
        $centroCosto = '';

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Coeficiente');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Coeficiente');
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['coeficiente']);
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }
        }

        $fila--;
        $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('ESTIMADO MATERIAS PRIMAS');

        //Fin del codigo de la hoja de totales

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Materias Primas.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoDepreciacion($year, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoCentroCostoMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Depreciación por divisiones")
            ->setSubject("Plan Estimado de Depreciación por divisiones")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PLAN ESTIMADO ' . $year . ' DE DEPRECIACIÓN');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('D6:D7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:E7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('F6:F7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:G7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('H6:H7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:I7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('J6:J7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:K7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('L6:L7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:M7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('N6:N7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:O7');

        $objPHPExcel->getActiveSheet(0)->freezePane('D8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'O'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
            } elseif ($i === 'C') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Contenido
        $fila = 8;
        $centroCosto = '';

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }
        }

        $fila--;
        $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('ESTIMADO DEPRECIACIÓN');

        //Fin del codigo de la hoja de totales

        //Por divisiones
        foreach ($divisionesCentrosCostos as $division) {
            $objPHPExcel->createSheet();
            $activeSheet++;
            $objPHPExcel->setActiveSheetIndex($activeSheet);

            //titulo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PLAN ESTIMADO ' . $year . ' DE DEPRECIACIÓN ' . strtoupper($division['division']));

            //Encabezados
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('D6:D7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:E7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('F6:F7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:G7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('H6:H7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:I7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('J6:J7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:K7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('L6:L7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:M7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('N6:N7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:O7');

            /* $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(4, 8);*/
            $objPHPExcel->getActiveSheet(0)->freezePane('D8');

            //Formato de la hoja
            $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
            $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

            for ($i = 'B'; $i <= 'O'; $i++) {
                if ($i === 'B') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
                } elseif ($i === 'C') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
                }
            }

            //Contenido
            $fila = 8;
            $centroCosto = '';

            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }

            $fila--;
            $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());

            $objPHPExcel->getActiveSheet()->setTitle($division['division']);

        }

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Depreciacion.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoAmortizacion($year, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoCentroCostoMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Amortización por divisiones")
            ->setSubject("Plan Estimado de Amortización por divisiones")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PLAN ESTIMADO ' . $year . ' DE AMORTIZACIÓN');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('D6:D7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:E7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('F6:F7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:G7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('H6:H7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:I7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('J6:J7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:K7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('L6:L7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:M7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('N6:N7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:O7');

        $objPHPExcel->getActiveSheet(0)->freezePane('D8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'O'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
            } elseif ($i === 'C') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Contenido
        $fila = 8;
        $centroCosto = '';

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }
        }

        $fila--;
        $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('ESTIMADO AMORTIZACIÓN');

        //Fin del codigo de la hoja de totales

        //Por divisiones
        foreach ($divisionesCentrosCostos as $division) {
            $objPHPExcel->createSheet();
            $activeSheet++;
            $objPHPExcel->setActiveSheetIndex($activeSheet);

            //titulo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'PLAN ESTIMADO ' . $year . ' DE AMORTIZACIÓN ' . strtoupper($division['division']));

            //Encabezados
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'TOTAL');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('D6:D7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:E7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('F6:F7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:G7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('H6:H7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:I7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('J6:J7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:K7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('L6:L7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:M7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('N6:N7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:O7');

            /* $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(4, 8);*/
            $objPHPExcel->getActiveSheet(0)->freezePane('D8');

            //Formato de la hoja
            $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
            $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

            for ($i = 'B'; $i <= 'O'; $i++) {
                if ($i === 'B') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
                } elseif ($i === 'C') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
                }
            }

            //Contenido
            $fila = 8;
            $centroCosto = '';

            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['presupuesto']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }

            $fila--;
            $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());

            $objPHPExcel->getActiveSheet()->setTitle($division['division']);

        }

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Amortizacion.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoCombustibleTotal($year, $totalMesCombustible, $tiposCombustibles, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoCentroCostoMes, $presupuestoDivisionesTipoCombustiblesMes, $presupuestoDivisionesLubricantesMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Combustible")
            ->setSubject("Plan Estimado de Combustible")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B1', 'PLAN ' . $year . ' ESTIMADO POR TIPO DE COMBUSTIBLE');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A2', 'TIPOS DE COMBUSTIBLES');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('A2:A3');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B2:B3');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'Meses');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C2:N2');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C3', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D3', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E3', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F3', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G3', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H3', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I3', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J3', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K3', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L3', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M3', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N3', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O2', 'Total');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O2:O3');

        $objPHPExcel->getActiveSheet(0)->freezePane('C4');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('B1:O1')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('A2:O3')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'A'; $i <= 'P'; $i++) {
            if ($i === 'A') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(25);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            }
        }

        //Contenido
        $fila = 4;

        $totalImporteEnero = 0;
        $totalImporteFebrero = 0;
        $totalImporteMarzo = 0;
        $totalImporteAbril = 0;
        $totalImporteMayo = 0;
        $totalImporteJunio = 0;
        $totalImporteJulio = 0;
        $totalImporteAgosto = 0;
        $totalImporteSeptiembre = 0;
        $totalImporteOctubre = 0;
        $totalImporteNoviembre = 0;
        $totalImporteDiciembre = 0;

        foreach ($tiposCombustibles as $tipo) {
            //Tipo de Combustible
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, $tipo['nombre']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':A' . $fila)->applyFromArray($this->estiloNegritas());
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'LTS');
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'IMPORTE');

            foreach ($totalMesCombustible as $mes) {
                if ($tipo['id'] === $mes['tipoCombustibleId']) {

                    switch ($mes['mes']) {
                        case 'enero':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteEnero += (int)$mes['importeCombustible'];
                            break;
                        case 'febrero':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteFebrero += (int)$mes['importeCombustible'];
                            break;
                        case 'marzo':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteMarzo += (int)$mes['importeCombustible'];
                            break;
                        case 'abril':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteAbril += (int)$mes['importeCombustible'];
                            break;
                        case 'mayo':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteMayo += (int)$mes['importeCombustible'];
                            break;
                        case 'junio':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteJunio += (int)$mes['importeCombustible'];
                            break;
                        case 'julio':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteJulio += (int)$mes['importeCombustible'];
                            break;
                        case 'agosto':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteAgosto += (int)$mes['importeCombustible'];
                            break;
                        case 'septiembre':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteSeptiembre += (int)$mes['importeCombustible'];
                            break;
                        case 'octubre':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteOctubre += (int)$mes['importeCombustible'];
                            break;
                        case 'noviembre':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteNoviembre += (int)$mes['importeCombustible'];
                            break;
                        case 'diciembre':
                            $fila--;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $mes['ltsCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $fila++;
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $mes['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalImporteDiciembre += (int)$mes['importeCombustible'];
                            break;
                    }
                }
            }

            // Sub Totales por fila
            //total de litros
            $fila--;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, '=SUM(C' . $fila . ':N' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            //total de importe
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, '=SUM(C' . $fila . ':N' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;

        }

        //Aceites y Lubricantes
        //Tipo de Combustible
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Lubricantes');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':A' . $fila)->applyFromArray($this->estiloNegritas());
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'LTS');
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'IMPORTE');

        foreach ($totalMesCombustible as $mes) {
            switch ($mes['mes']) {
                case 'enero':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteEnero += (int)$mes['importeLubricante'];
                    break;
                case 'febrero':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteFebrero += (int)$mes['importeLubricante'];
                    break;
                case 'marzo':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteMarzo += (int)$mes['importeLubricante'];
                    break;
                case 'abril':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteAbril += (int)$mes['importeLubricante'];
                    break;
                case 'mayo':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteMayo += (int)$mes['importeLubricante'];
                    break;
                case 'junio':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteJunio += (int)$mes['importeLubricante'];
                    break;
                case 'julio':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $mes['importeCombustible']);
                    $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteJulio += (int)$mes['importeLubricante'];
                    break;
                case 'agosto':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteAgosto += (int)$mes['importeLubricante'];
                    break;
                case 'septiembre':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteSeptiembre += (int)$mes['importeLubricante'];
                    break;
                case 'octubre':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteOctubre += (int)$mes['importeLubricante'];
                    break;
                case 'noviembre':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteNoviembre += (int)$mes['importeLubricante'];
                    break;
                case 'diciembre':
                    $fila--;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $mes['ltsLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $mes['importeLubricante']);
                    $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                    $totalImporteDiciembre += (int)$mes['importeLubricante'];
                    break;
            }
        }

        // Sub Totales por fila
        //total de litros
        $fila--;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, '=SUM(C' . $fila . ':N' . $fila . ')');
        $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->getActiveSheet()->getStyle('O' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
        //total de importe
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, '=SUM(C' . $fila . ':N' . $fila . ')');
        $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('O' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
        $fila++;

        //Totales
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Importe Total');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalImporteEnero);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteFebrero);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $totalImporteMarzo);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $totalImporteAbril);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $totalImporteMayo);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalImporteJunio);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $totalImporteJulio);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $totalImporteAgosto);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $totalImporteSeptiembre);
        $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $totalImporteOctubre);
        $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $totalImporteNoviembre);
        $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $totalImporteDiciembre);
        $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, '=SUM(C' . $fila . ':N' . $fila . ')');
        $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());

        $objPHPExcel->getActiveSheet()->getStyle('A4:O' . $fila)->applyFromArray($this->estiloBordesVentas());

        $objPHPExcel->getActiveSheet()->setTitle('TOTALES');

        //Fin del codigo de la hoja de totales

        //Hoja no.2 Desglose del importe por división y centros de costos
        $objPHPExcel->createSheet();
        $activeSheet++;
        $objPHPExcel->setActiveSheetIndex($activeSheet);

        $totalDivisionEnero = 0;
        $totalDivisionFebrero = 0;
        $totalDivisionMarzo = 0;
        $totalDivisionAbril = 0;
        $totalDivisionMayo = 0;
        $totalDivisionJunio = 0;
        $totalDivisionJulio = 0;
        $totalDivisionAgosto = 0;
        $totalDivisionSeptiembre = 0;
        $totalDivisionOctubre = 0;
        $totalDivisionNoviembre = 0;
        $totalDivisionDiciembre = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'DESGLOSE ESTIMADO ' . $year . ' DEL IMPORTE DE COMBUSTIBLE, ACEITES Y LUBRICANTES');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'Total Anual');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('D6:D7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:E7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('F6:F7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:G7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('H6:H7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:I7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('J6:J7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:K7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('L6:L7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:M7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('N6:N7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:O7');

        $objPHPExcel->getActiveSheet(0)->freezePane('D8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'O'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
            } elseif ($i === 'C') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Contenido
        $fila = 8;
        $centroCosto = '';

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionEnero += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionFebrero += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMarzo += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAbril += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMayo += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJunio += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJulio += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAgosto += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionSeptiembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionOctubre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionNoviembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionDiciembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }
        }

        //Total genral
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total General');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalDivisionEnero);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $totalDivisionFebrero);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $totalDivisionMarzo);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $totalDivisionAbril);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalDivisionMayo);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $totalDivisionJunio);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $totalDivisionJulio);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $totalDivisionAgosto);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $totalDivisionSeptiembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $totalDivisionOctubre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $totalDivisionNoviembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $totalDivisionDiciembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());

        $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('IMPORTE DIVISIÓN');

        //Hoja no.3 Desglose por tipo de combustible y lubricantes por division
        $objPHPExcel->createSheet();
        $activeSheet++;
        $objPHPExcel->setActiveSheetIndex($activeSheet);

        $totalDivisionEnero = 0;
        $totalDivisionFebrero = 0;
        $totalDivisionMarzo = 0;
        $totalDivisionAbril = 0;
        $totalDivisionMayo = 0;
        $totalDivisionJunio = 0;
        $totalDivisionJulio = 0;
        $totalDivisionAgosto = 0;
        $totalDivisionSeptiembre = 0;
        $totalDivisionOctubre = 0;
        $totalDivisionNoviembre = 0;
        $totalDivisionDiciembre = 0;

        $ltsTipoCombustibleEnero = 0;
        $ltsTipoCombustibleFebrero = 0;
        $ltsTipoCombustibleMarzo = 0;
        $ltsTipoCombustibleAbril = 0;
        $ltsTipoCombustibleMayo = 0;
        $ltsTipoCombustibleJunio = 0;
        $ltsTipoCombustibleJulio = 0;
        $ltsTipoCombustibleAgosto = 0;
        $ltsTipoCombustibleSeptiembre = 0;
        $ltsTipoCombustibleOctubre = 0;
        $ltsTipoCombustibleNoviembre = 0;
        $ltsTipoCombustibleDiciembre = 0;

        $importeTipoCombustibleEnero = 0;
        $importeTipoCombustibleFebrero = 0;
        $importeTipoCombustibleMarzo = 0;
        $importeTipoCombustibleAbril = 0;
        $importeTipoCombustibleMayo = 0;
        $importeTipoCombustibleJunio = 0;
        $importeTipoCombustibleJulio = 0;
        $importeTipoCombustibleAgosto = 0;
        $importeTipoCombustibleSeptiembre = 0;
        $importeTipoCombustibleOctubre = 0;
        $importeTipoCombustibleNoviembre = 0;
        $importeTipoCombustibleDiciembre = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'DESGLOSE ESTIMADO DEL PLAN DE COMBUSTIBLE ' . $year);

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'Total Anual');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:D6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:F6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:H6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:J6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:L6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:N6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:P6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Q6:R6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('S6:T6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('U6:V6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('W6:X6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Y6:Z6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA6', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AA6:AB6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB7', 'Importe');

        $objPHPExcel->getActiveSheet(0)->freezePane('E8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:AB7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'Z'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(15);
            }
        }

        //Contenido
        $fila = 8;
        $tipoCombustible = '';
        $totalLTSTipoCombustible = 0;
        $totalImporteTipoCombustible = 0;
        $totalImporteGeneralTipoCombustible = 0;
        $cantidadMedios = 0;

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoDivisionesTipoCombustiblesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $tipoCombustible = $presupuesto['tipoCombustible'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':AB' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionEnero += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionFebrero += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMarzo += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAbril += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMayo += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJunio += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJulio += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAgosto += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionSeptiembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionOctubre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionNoviembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionDiciembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                    }
                }
            }
            //Totales
            $totalImporteGeneralTipoCombustible = $totalDivisionEnero + $totalDivisionFebrero + $totalDivisionMarzo + $totalDivisionAbril + $totalDivisionMayo + $totalDivisionJunio + $totalDivisionJulio + $totalDivisionAgosto + $totalDivisionSeptiembre + $totalDivisionOctubre + $totalDivisionNoviembre + $totalDivisionDiciembre;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, '=SUM(D' . $fila . ':AB' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':AB' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Tipo de combustible por division
            foreach ($presupuestoDivisionesTipoCombustiblesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($tipoCombustible === $presupuesto['tipoCombustible']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['tipoCombustible']);
                        //Medios de transportes
                        /*$cantidadMedios = 0;
                        foreach ($presupuestoMedioTransporteMes as $medio) {
                            if ($tipoCombustible === $medio['tipoCombustible']  && $division['division'] === $medio['division'] ) {
                                $fila++;
                                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $medio['modeloNombre']);
                                $cantidadMedios++;
                            }
                        }
                        $fila -= $cantidadMedios;*/
                    } else {
                        $totalLTSTipoCombustible = 0;
                        $totalImporteTipoCombustible = 0;
                        $totalLTSTipoCombustible = $ltsTipoCombustibleEnero + $ltsTipoCombustibleFebrero + $ltsTipoCombustibleMarzo + $ltsTipoCombustibleAbril + $ltsTipoCombustibleMayo + $ltsTipoCombustibleJunio + $ltsTipoCombustibleJulio + $ltsTipoCombustibleAgosto + $ltsTipoCombustibleSeptiembre + $ltsTipoCombustibleOctubre + $ltsTipoCombustibleNoviembre + $ltsTipoCombustibleDiciembre;
                        $totalImporteTipoCombustible = $importeTipoCombustibleEnero + $importeTipoCombustibleFebrero + $importeTipoCombustibleMarzo + $importeTipoCombustibleAbril + $importeTipoCombustibleMayo + $importeTipoCombustibleJunio + $importeTipoCombustibleJulio + $importeTipoCombustibleAgosto + $importeTipoCombustibleSeptiembre + $importeTipoCombustibleOctubre + $importeTipoCombustibleNoviembre + $importeTipoCombustibleDiciembre;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalLTSTipoCombustible);
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteTipoCombustible);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['tipoCombustible']);
                    }
                    $tipoCombustible = $presupuesto['tipoCombustible'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleEnero = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleEnero = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleFebrero = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleFebrero = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleMarzo = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleMarzo = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleAbril = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleAbril = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleMayo = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleMayo = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleJunio = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleJunio = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleJulio = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleJulio = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleAgosto = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleAgosto = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('S' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleSeptiembre = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleSeptiembre = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('U' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleOctubre = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleOctubre = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('W' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleNoviembre = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleNoviembre = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleDiciembre = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleDiciembre = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $totalLTSTipoCombustible = 0;
                $totalImporteTipoCombustible = 0;
                $totalLTSTipoCombustible = $ltsTipoCombustibleEnero + $ltsTipoCombustibleFebrero + $ltsTipoCombustibleMarzo + $ltsTipoCombustibleAbril + $ltsTipoCombustibleMayo + $ltsTipoCombustibleJunio + $ltsTipoCombustibleJulio + $ltsTipoCombustibleAgosto + $ltsTipoCombustibleSeptiembre + $ltsTipoCombustibleOctubre + $ltsTipoCombustibleNoviembre + $ltsTipoCombustibleDiciembre;
                $totalImporteTipoCombustible = $importeTipoCombustibleEnero + $importeTipoCombustibleFebrero + $importeTipoCombustibleMarzo + $importeTipoCombustibleAbril + $importeTipoCombustibleMayo + $importeTipoCombustibleJunio + $importeTipoCombustibleJulio + $importeTipoCombustibleAgosto + $importeTipoCombustibleSeptiembre + $importeTipoCombustibleOctubre + $importeTipoCombustibleNoviembre + $importeTipoCombustibleDiciembre;
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalLTSTipoCombustible);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteTipoCombustible);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }

            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Lubricantes');
            //Lubricantes
            foreach ($presupuestoDivisionesLubricantesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleEnero = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleEnero = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleFebrero = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleFebrero = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleMarzo = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleMarzo = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleAbril = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleAbril = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleMayo = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleMayo = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleJunio = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleJunio = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleJulio = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleJulio = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleAgosto = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleAgosto = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('S' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleSeptiembre = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleSeptiembre = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('U' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleOctubre = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleOctubre = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('W' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleNoviembre = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleNoviembre = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleDiciembre = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleDiciembre = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                    }
                }
            }
            //Totales de Lubricantes
            $totalLTSTipoCombustible = 0;
            $totalImporteTipoCombustible = 0;
            $totalLTSTipoCombustible = $ltsTipoCombustibleEnero + $ltsTipoCombustibleFebrero + $ltsTipoCombustibleMarzo + $ltsTipoCombustibleAbril + $ltsTipoCombustibleMayo + $ltsTipoCombustibleJunio + $ltsTipoCombustibleJulio + $ltsTipoCombustibleAgosto + $ltsTipoCombustibleSeptiembre + $ltsTipoCombustibleOctubre + $ltsTipoCombustibleNoviembre + $ltsTipoCombustibleDiciembre;
            $totalImporteTipoCombustible = $importeTipoCombustibleEnero + $importeTipoCombustibleFebrero + $importeTipoCombustibleMarzo + $importeTipoCombustibleAbril + $importeTipoCombustibleMayo + $importeTipoCombustibleJunio + $importeTipoCombustibleJulio + $importeTipoCombustibleAgosto + $importeTipoCombustibleSeptiembre + $importeTipoCombustibleOctubre + $importeTipoCombustibleNoviembre + $importeTipoCombustibleDiciembre;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalLTSTipoCombustible);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteTipoCombustible);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $fila++;
        }

        //Total genral
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total Importe General');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $totalDivisionEnero);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalDivisionFebrero);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $totalDivisionMarzo);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $totalDivisionAbril);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $totalDivisionMayo);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $totalDivisionJunio);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $totalDivisionJulio);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $totalDivisionAgosto);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $totalDivisionSeptiembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $totalDivisionOctubre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $totalDivisionNoviembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $totalDivisionDiciembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteGeneralTipoCombustible);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':AE' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':AE' . $fila)->applyFromArray($this->estiloNegritas());

        $objPHPExcel->getActiveSheet()->getStyle('B8:AB' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('TIPOS DE COMBUSTIBLE');

        //Fin del codigo de la hoja de totales


        //Fin del codigo del importe por división y centro de costo

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Combustible.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoCombustibleDivisionCentro($year, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoCentroCostoMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Combustible por divisiones")
            ->setSubject("Plan Estimado de Combustible por divisiones")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        $totalDivisionEnero = 0;
        $totalDivisionFebrero = 0;
        $totalDivisionMarzo = 0;
        $totalDivisionAbril = 0;
        $totalDivisionMayo = 0;
        $totalDivisionJunio = 0;
        $totalDivisionJulio = 0;
        $totalDivisionAgosto = 0;
        $totalDivisionSeptiembre = 0;
        $totalDivisionOctubre = 0;
        $totalDivisionNoviembre = 0;
        $totalDivisionDiciembre = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'DESGLOSE ESTIMADO ' . $year . ' DEL IMPORTE DE COMBUSTIBLE, ACEITES Y LUBRICANTES');

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'Total Anual');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('D6:D7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:E7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('F6:F7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:G7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('H6:H7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:I7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('J6:J7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:K7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('L6:L7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:M7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('N6:N7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:O7');

        $objPHPExcel->getActiveSheet(0)->freezePane('D8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:O7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'O'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
            } elseif ($i === 'C') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(14);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Contenido
        $fila = 8;
        $centroCosto = '';

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $centroCosto = $presupuesto['centro'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionEnero += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionFebrero += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMarzo += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAbril += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMayo += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJunio += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJulio += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAgosto += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionSeptiembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionOctubre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionNoviembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionDiciembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                    }
                }
            }
            //Totales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Centro de Costo de la division
            foreach ($presupuestoCentroCostoMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($centroCosto === $presupuesto['centro']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['centro']);
                    }
                    $centroCosto = $presupuesto['centro'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }
        }

        //Total genral
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total General');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalDivisionEnero);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $totalDivisionFebrero);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $totalDivisionMarzo);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $totalDivisionAbril);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalDivisionMayo);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $totalDivisionJunio);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $totalDivisionJulio);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $totalDivisionAgosto);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $totalDivisionSeptiembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $totalDivisionOctubre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $totalDivisionNoviembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $totalDivisionDiciembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, '=SUM(D' . $fila . ':O' . $fila . ')');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':O' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':O' . $fila)->applyFromArray($this->estiloNegritas());

        $objPHPExcel->getActiveSheet()->getStyle('B8:O' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('IMPORTE DIVISIÓN');

        //Fin del codigo de la hoja de totales

        //Por divisiones


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Combustible.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoCombustibleMedioTransporte($year, $divisionesCentrosCostos, $presupuestoDivisionesMes, $presupuestoDivisionesTipoCombustiblesMes, $presupuestoMedioTransporteMes, $presupuestoDivisionesLubricantesMes)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado de Combustible por divisiones")
            ->setSubject("Plan Estimado de Combustible por divisiones")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        $totalDivisionEnero = 0;
        $totalDivisionFebrero = 0;
        $totalDivisionMarzo = 0;
        $totalDivisionAbril = 0;
        $totalDivisionMayo = 0;
        $totalDivisionJunio = 0;
        $totalDivisionJulio = 0;
        $totalDivisionAgosto = 0;
        $totalDivisionSeptiembre = 0;
        $totalDivisionOctubre = 0;
        $totalDivisionNoviembre = 0;
        $totalDivisionDiciembre = 0;

        $ltsTipoCombustibleEnero = 0;
        $ltsTipoCombustibleFebrero = 0;
        $ltsTipoCombustibleMarzo = 0;
        $ltsTipoCombustibleAbril = 0;
        $ltsTipoCombustibleMayo = 0;
        $ltsTipoCombustibleJunio = 0;
        $ltsTipoCombustibleJulio = 0;
        $ltsTipoCombustibleAgosto = 0;
        $ltsTipoCombustibleSeptiembre = 0;
        $ltsTipoCombustibleOctubre = 0;
        $ltsTipoCombustibleNoviembre = 0;
        $ltsTipoCombustibleDiciembre = 0;

        $importeTipoCombustibleEnero = 0;
        $importeTipoCombustibleFebrero = 0;
        $importeTipoCombustibleMarzo = 0;
        $importeTipoCombustibleAbril = 0;
        $importeTipoCombustibleMayo = 0;
        $importeTipoCombustibleJunio = 0;
        $importeTipoCombustibleJulio = 0;
        $importeTipoCombustibleAgosto = 0;
        $importeTipoCombustibleSeptiembre = 0;
        $importeTipoCombustibleOctubre = 0;
        $importeTipoCombustibleNoviembre = 0;
        $importeTipoCombustibleDiciembre = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'DESGLOSE ESTIMADO DEL PLAN DE COMBUSTIBLE ' . $year);

        //Encabezados
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'DIVISIONES / GRUPOS');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'Total Anual');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:D6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:F6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:H6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:J6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:L6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:N6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:P6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q6', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Q6:R6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S6', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('S6:T6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U6', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('U6:V6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W6', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('W6:X6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y6', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Y6:Z6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z7', 'Importe');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA6', 'Diciembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AA6:AB6');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA7', 'Lts');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB7', 'Importe');

        $objPHPExcel->getActiveSheet(0)->freezePane('E8');

        //Formato de la hoja
        $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
        $objPHPExcel->getActiveSheet()->getStyle('B6:AB7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

        for ($i = 'B'; $i <= 'Z'; $i++) {
            if ($i === 'B') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(15);
            }
        }

        //Contenido
        $fila = 8;
        $tipoCombustible = '';
        $totalLTSTipoCombustible = 0;
        $totalImporteTipoCombustible = 0;
        $totalImporteGeneralTipoCombustible = 0;
        $cantidadMedios = 0;

        foreach ($divisionesCentrosCostos as $division) {
            //Obtener el primer value de centro de costo de esta division
            foreach ($presupuestoDivisionesTipoCombustiblesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $tipoCombustible = $presupuesto['tipoCombustible'];
                    break;
                }
            }
            //Division
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $division['division']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':AB' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            foreach ($presupuestoDivisionesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionEnero += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionFebrero += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMarzo += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAbril += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMayo += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJunio += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJulio += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAgosto += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionSeptiembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionOctubre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionNoviembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['importeCombustible'] + $presupuesto['importeLubricante']);
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionDiciembre += $presupuesto['importeCombustible'] + $presupuesto['importeLubricante'];
                            break;
                    }
                }
            }
            //Totales
            $totalImporteGeneralTipoCombustible = $totalDivisionEnero + $totalDivisionFebrero + $totalDivisionMarzo + $totalDivisionAbril + $totalDivisionMayo + $totalDivisionJunio + $totalDivisionJulio + $totalDivisionAgosto + $totalDivisionSeptiembre + $totalDivisionOctubre + $totalDivisionNoviembre + $totalDivisionDiciembre;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, '=SUM(D' . $fila . ':AB' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':AB' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;
            $existe = false;
            //Tipo de combustible por division
            foreach ($presupuestoDivisionesTipoCombustiblesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    $existe = true;
                    if ($tipoCombustible === $presupuesto['tipoCombustible']) {
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['tipoCombustible']);
                        //Medios de transportes
                        /*$cantidadMedios = 0;
                        foreach ($presupuestoMedioTransporteMes as $medio) {
                            if ($tipoCombustible === $medio['tipoCombustible']  && $division['division'] === $medio['division'] ) {
                                $fila++;
                                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $medio['modeloNombre']);
                                $cantidadMedios++;
                            }
                        }
                        $fila -= $cantidadMedios;*/
                    } else {
                        $totalLTSTipoCombustible = 0;
                        $totalImporteTipoCombustible = 0;
                        $totalLTSTipoCombustible = $ltsTipoCombustibleEnero + $ltsTipoCombustibleFebrero + $ltsTipoCombustibleMarzo + $ltsTipoCombustibleAbril + $ltsTipoCombustibleMayo + $ltsTipoCombustibleJunio + $ltsTipoCombustibleJulio + $ltsTipoCombustibleAgosto + $ltsTipoCombustibleSeptiembre + $ltsTipoCombustibleOctubre + $ltsTipoCombustibleNoviembre + $ltsTipoCombustibleDiciembre;
                        $totalImporteTipoCombustible = $importeTipoCombustibleEnero + $importeTipoCombustibleFebrero + $importeTipoCombustibleMarzo + $importeTipoCombustibleAbril + $importeTipoCombustibleMayo + $importeTipoCombustibleJunio + $importeTipoCombustibleJulio + $importeTipoCombustibleAgosto + $importeTipoCombustibleSeptiembre + $importeTipoCombustibleOctubre + $importeTipoCombustibleNoviembre + $importeTipoCombustibleDiciembre;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalLTSTipoCombustible);
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteTipoCombustible);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                        $fila++;
                        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['tipoCombustible']);
                    }
                    $tipoCombustible = $presupuesto['tipoCombustible'];

                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleEnero = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleEnero = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleFebrero = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleFebrero = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleMarzo = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleMarzo = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleAbril = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleAbril = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleMayo = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleMayo = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleJunio = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleJunio = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleJulio = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleJulio = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleAgosto = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleAgosto = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('S' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleSeptiembre = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleSeptiembre = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('U' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleOctubre = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleOctubre = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('W' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleNoviembre = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleNoviembre = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA' . $fila, $presupuesto['ltsCombustible']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['importeCombustible']);
                            $ltsTipoCombustibleDiciembre = $presupuesto['ltsCombustible'];
                            $importeTipoCombustibleDiciembre = $presupuesto['importeCombustible'];
                            $objPHPExcel->getActiveSheet()->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                    }
                }
            }
            //Totales
            if ($existe) {
                $totalLTSTipoCombustible = 0;
                $totalImporteTipoCombustible = 0;
                $totalLTSTipoCombustible = $ltsTipoCombustibleEnero + $ltsTipoCombustibleFebrero + $ltsTipoCombustibleMarzo + $ltsTipoCombustibleAbril + $ltsTipoCombustibleMayo + $ltsTipoCombustibleJunio + $ltsTipoCombustibleJulio + $ltsTipoCombustibleAgosto + $ltsTipoCombustibleSeptiembre + $ltsTipoCombustibleOctubre + $ltsTipoCombustibleNoviembre + $ltsTipoCombustibleDiciembre;
                $totalImporteTipoCombustible = $importeTipoCombustibleEnero + $importeTipoCombustibleFebrero + $importeTipoCombustibleMarzo + $importeTipoCombustibleAbril + $importeTipoCombustibleMayo + $importeTipoCombustibleJunio + $importeTipoCombustibleJulio + $importeTipoCombustibleAgosto + $importeTipoCombustibleSeptiembre + $importeTipoCombustibleOctubre + $importeTipoCombustibleNoviembre + $importeTipoCombustibleDiciembre;
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalLTSTipoCombustible);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteTipoCombustible);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $fila++;
            }

            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Lubricantes');
            //Lubricantes
            foreach ($presupuestoDivisionesLubricantesMes as $presupuesto) {
                if ($division['division'] === $presupuesto['division']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleEnero = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleEnero = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleFebrero = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleFebrero = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleMarzo = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleMarzo = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleAbril = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleAbril = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleMayo = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleMayo = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleJunio = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleJunio = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleJulio = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleJulio = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleAgosto = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleAgosto = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('S' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleSeptiembre = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleSeptiembre = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('U' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleOctubre = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleOctubre = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('W' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleNoviembre = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleNoviembre = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA' . $fila, $presupuesto['ltsLubricante']);
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['importeLubricante']);
                            $ltsTipoCombustibleDiciembre = $presupuesto['ltsLubricante'];
                            $importeTipoCombustibleDiciembre = $presupuesto['importeLubricante'];
                            $objPHPExcel->getActiveSheet()->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('#,##0');
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            break;
                    }
                }
            }
            //Totales de Lubricantes
            $totalLTSTipoCombustible = 0;
            $totalImporteTipoCombustible = 0;
            $totalLTSTipoCombustible = $ltsTipoCombustibleEnero + $ltsTipoCombustibleFebrero + $ltsTipoCombustibleMarzo + $ltsTipoCombustibleAbril + $ltsTipoCombustibleMayo + $ltsTipoCombustibleJunio + $ltsTipoCombustibleJulio + $ltsTipoCombustibleAgosto + $ltsTipoCombustibleSeptiembre + $ltsTipoCombustibleOctubre + $ltsTipoCombustibleNoviembre + $ltsTipoCombustibleDiciembre;
            $totalImporteTipoCombustible = $importeTipoCombustibleEnero + $importeTipoCombustibleFebrero + $importeTipoCombustibleMarzo + $importeTipoCombustibleAbril + $importeTipoCombustibleMayo + $importeTipoCombustibleJunio + $importeTipoCombustibleJulio + $importeTipoCombustibleAgosto + $importeTipoCombustibleSeptiembre + $importeTipoCombustibleOctubre + $importeTipoCombustibleNoviembre + $importeTipoCombustibleDiciembre;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalLTSTipoCombustible);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteTipoCombustible);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $fila++;
        }

        //Total genral
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Total Importe General');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $totalDivisionEnero);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalDivisionFebrero);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $totalDivisionMarzo);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $totalDivisionAbril);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $totalDivisionMayo);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $totalDivisionJunio);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $totalDivisionJulio);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $totalDivisionAgosto);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $totalDivisionSeptiembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $totalDivisionOctubre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $totalDivisionNoviembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $totalDivisionDiciembre);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteGeneralTipoCombustible);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':AE' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':AE' . $fila)->applyFromArray($this->estiloNegritas());

        $objPHPExcel->getActiveSheet()->getStyle('B8:AB' . $fila)->applyFromArray($this->estiloBordesVentas());


        $objPHPExcel->getActiveSheet()->setTitle('MEDIOS DE TRANSPORTES');

        //Fin del codigo de la hoja de totales

        //Por divisiones


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Combustible.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPlanEstimadoTipoCombustibleProvincia($year, $tiposCombustibles, $presupuestoProvinciaMes)
    {

        $existe = false;

        foreach ($tiposCombustibles as $tipo) {

            if (!$existe) {
                $objPHPExcel = new Spreadsheet();

                $objPHPExcel->getProperties()
                    ->setCreator("YADRIAN y ALAIN")
                    ->setLastModifiedBy("GESCOST")
                    ->setTitle("Plan Estimado de Combustible por divisiones")
                    ->setSubject("Plan Estimado de Combustible por divisiones")
                    ->setDescription("Documento generado con GESCOST")
                    ->setKeywords("GESCOST")
                    ->setCategory("REPORTES");

                //inicio del codigo de la hoja de totales
                $activeSheet = 0;
                $existe = true;
            }else {
                $objPHPExcel->createSheet();
                $activeSheet++;
                $objPHPExcel->setActiveSheetIndex($activeSheet);
            }

            $totalDivisionEnero = 0;
            $totalDivisionFebrero = 0;
            $totalDivisionMarzo = 0;
            $totalDivisionAbril = 0;
            $totalDivisionMayo = 0;
            $totalDivisionJunio = 0;
            $totalDivisionJulio = 0;
            $totalDivisionAgosto = 0;
            $totalDivisionSeptiembre = 0;
            $totalDivisionOctubre = 0;
            $totalDivisionNoviembre = 0;
            $totalDivisionDiciembre = 0;

            $ltsTipoCombustibleEnero = 0;
            $ltsTipoCombustibleFebrero = 0;
            $ltsTipoCombustibleMarzo = 0;
            $ltsTipoCombustibleAbril = 0;
            $ltsTipoCombustibleMayo = 0;
            $ltsTipoCombustibleJunio = 0;
            $ltsTipoCombustibleJulio = 0;
            $ltsTipoCombustibleAgosto = 0;
            $ltsTipoCombustibleSeptiembre = 0;
            $ltsTipoCombustibleOctubre = 0;
            $ltsTipoCombustibleNoviembre = 0;
            $ltsTipoCombustibleDiciembre = 0;

            $importeTipoCombustibleEnero = 0;
            $importeTipoCombustibleFebrero = 0;
            $importeTipoCombustibleMarzo = 0;
            $importeTipoCombustibleAbril = 0;
            $importeTipoCombustibleMayo = 0;
            $importeTipoCombustibleJunio = 0;
            $importeTipoCombustibleJulio = 0;
            $importeTipoCombustibleAgosto = 0;
            $importeTipoCombustibleSeptiembre = 0;
            $importeTipoCombustibleOctubre = 0;
            $importeTipoCombustibleNoviembre = 0;
            $importeTipoCombustibleDiciembre = 0;

            //titulo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C2', 'DESGLOSE ESTIMADO PROVINCIAL ' . $year . ' POR TIPO DE COMBUSTIBLE');

            //Encabezados
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B6', 'PROVINCIAS');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B6:B7');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C6', 'Total Anual');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('C6:D6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E6', 'Enero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('E6:F6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G6', 'Febrero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('G6:H6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I6', 'Marzo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('I6:J6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K6', 'Abril');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('K6:L6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M6', 'Mayo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('M6:N6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O6', 'Junio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('O6:P6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q6', 'Julio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Q6:R6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Q7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S6', 'Agosto');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('S6:T6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('S7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U6', 'Septiembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('U6:V6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('U7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W6', 'Octubre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('W6:X6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('W7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y6', 'Noviembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('Y6:Z6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Y7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z7', 'Importe');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA6', 'Diciembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('AA6:AB6');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AA7', 'Lts');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB7', 'Importe');

            $objPHPExcel->getActiveSheet(0)->freezePane('E8');

            //Formato de la hoja
            $objPHPExcel->getActiveSheet()->getStyle('C2:O2')->applyFromArray($this->estiloTituloReporteVenta());
            $objPHPExcel->getActiveSheet()->getStyle('B6:AB7')->applyFromArray($this->estiloEncabezadosColumnasVenta());

            for ($i = 'B'; $i <= 'Z'; $i++) {
                if ($i === 'B') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(28);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(15);
                }
            }

            //Contenido
            $fila = 8;
            $tipoCombustible = '';
            $totalLTSTipoCombustible = 0;
            $totalImporteTipoCombustible = 0;
            $totalImporteGeneralTipoCombustible = 0;
            $cantidadMedios = 0;

            //Provincias
            foreach ($presupuestoProvinciaMes as $presupuesto) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['provincia']);
                if ($tipo['nombre'] === $presupuesto['tipoCombustible']) {
                    switch ($presupuesto['mes']) {
                        case 'enero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionEnero += $presupuesto['importeCombustible'];
                            break;
                        case 'febrero':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionFebrero += $presupuesto['importeCombustible'];
                            break;
                        case 'marzo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMarzo += $presupuesto['importeCombustible'];
                            break;
                        case 'abril':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAbril += $presupuesto['importeCombustible'];
                            break;
                        case 'mayo':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionMayo += $presupuesto['importeCombustible'];
                            break;
                        case 'junio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJunio += $presupuesto['importeCombustible'];
                            break;
                        case 'julio':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionJulio += $presupuesto['importeCombustible'];
                            break;
                        case 'agosto':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionAgosto += $presupuesto['importeCombustible'];
                            break;
                        case 'septiembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionSeptiembre += $presupuesto['importeCombustible'];
                            break;
                        case 'octubre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('X' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionOctubre += $presupuesto['importeCombustible'];
                            break;
                        case 'noviembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionNoviembre += $presupuesto['importeCombustible'];
                            break;
                        case 'diciembre':
                            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $presupuesto['importeCombustible']);
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                            $totalDivisionDiciembre += $presupuesto['importeCombustible'];
                            break;
                    }
                }
            }
            //Totales
            $totalImporteGeneralTipoCombustible = $totalDivisionEnero + $totalDivisionFebrero + $totalDivisionMarzo + $totalDivisionAbril + $totalDivisionMayo + $totalDivisionJunio + $totalDivisionJulio + $totalDivisionAgosto + $totalDivisionSeptiembre + $totalDivisionOctubre + $totalDivisionNoviembre + $totalDivisionDiciembre;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, '=SUM(D' . $fila . ':AB' . $fila . ')');
            $objPHPExcel->getActiveSheet()->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':AB' . $fila)->applyFromArray($this->estiloNegritas());
            $fila++;

            //Total genral
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'Totales');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $totalDivisionEnero);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H' . $fila, $totalDivisionFebrero);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J' . $fila, $totalDivisionMarzo);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L' . $fila, $totalDivisionAbril);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N' . $fila, $totalDivisionMayo);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('P' . $fila, $totalDivisionJunio);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('R' . $fila, $totalDivisionJulio);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('T' . $fila, $totalDivisionAgosto);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('V' . $fila, $totalDivisionSeptiembre);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('X' . $fila, $totalDivisionOctubre);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('Z' . $fila, $totalDivisionNoviembre);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('AB' . $fila, $totalDivisionDiciembre);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalImporteGeneralTipoCombustible);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':D' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':AE' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $fila . ':AE' . $fila)->applyFromArray($this->estiloNegritas());

            $objPHPExcel->getActiveSheet()->getStyle('B8:AB' . $fila)->applyFromArray($this->estiloBordesVentas());



            $objPHPExcel->getActiveSheet()->setTitle($tipo['nombre']);
        }

        //Fin del codigo de la hoja de totales

        //Por divisiones


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Combustible.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }


    public function exportarPlanEstimadoDivision($year, $datos)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("GESCOST")
            ->setTitle("Plan Estimado Division")
            ->setSubject("Plan Estimado Division")
            ->setDescription("Documento generado con GESCOST")
            ->setKeywords("GESCOST")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja de totales
        $activeSheet = 0;

        //titulo
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A2', 'EMPRESA: ECODIC');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A3', $datos['divisionVenta'][0]['division']);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B3', 'APERTURA MENSUAL PLAN INDICADORES PRINCIPALES');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A4', 'AÑO ' . $year);

        //Encabezados verticales
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A6', 'INDICADORES');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B5', 'TOTAL AÑO');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C5', 'APERTURA');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D5', 'Enero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E5', 'Febrero');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F5', 'Marzo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G5', 'Abril');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H5', 'Mayo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I5', 'Junio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J5', 'Julio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K5', 'Agosto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L5', 'Septiembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M5', 'Octubre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N5', 'Noviembre');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O5', 'Diciembre');

        $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0, 6);

        //Encabezados horizontales
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A7', 'Ventas Totales');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A8', 'Promedio de Trabajadores');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A9', 'Productividad / Ventas');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A10', 'Salario Medio Mensual');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A11', 'Gasto de Salario ps Venta');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A12', 'Gasto Total');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A13', 'De ellos : Costo de Venta');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A14', 'Utilidad');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A15', 'Gasto de Fuerza de Trabajo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A16', 'Fondo de Salarios');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A17', 'Seguridad Social');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A18', 'Impuesto de la Fuerza de Trabajo');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A19', 'Gasto Material');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A20', 'Materias Primas');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A21', 'Combustibles y Lubricantes');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A22', 'Energia');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A23', 'Depreciacion  AFT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A24', 'Amortizacion  AFT');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A25', 'Otros Gastos');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A26', 'Servicios recibidos');

        //Impresión de los servicios recibidos q no son todos los otros gastos monetarios

        $fila = 27;

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Productividad / V.Agregado');
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Gasto Salario ps Prod. Mercantil');
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Gasto Salario ps V.Agregado');
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Valor Agregado');
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Gasto Total/Ingreso Total');
        $fila++;

        //Contenido-Fila Ventas Totales
        //Total año
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B7', $datos['divisionVenta'][0]['totalVentaDivision']);

        $columna = 'D';
        //Meses-Ventas
        foreach ($datos['divisionVentaMes'] as $ventaMes) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($columna++ . '7', $ventaMes['totalVentaDivisionMes']);
        }

        //Apertura-Ventas
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C7', '=SUM(D7:O7)');

        //Contenido-Fila Promedio de trabajadores
        //Total año
        //$objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B8', $datos['divisionSalario'][0]['totalPromedioTrabajador']);

        $columna = 'D';
        //Meses-Promedio de trabajadores
        /*foreach ($datos['divisionSalarioMes'] as $salarioMes) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($columna++ . '8', $salarioMes['totalPromedioTrabajadorMes']);
        }*/

        //Apertura-Promedio de trabajadores
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C8', '=SUM(D8:O8)/12');

        //Contenido-Fila Productividad / Ventas
        //Total año
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B9', '=(B7/B8)/12');

        //Apertura-Productividad / Ventas
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C9', '=(C7/C8)/12');

        //Meses-Productividad / Ventas
        for ($i = 'D'; $i <= 'O'; $i++) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '9', '=(' . $i . '7/' . $i . '8)/12');
        }

        //Contenido-Fila Fondo de Salarios
        //Total año
        //$objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B16', $datos['divisionSalario'][0]['totalSalarioDivision']);

        $columna = 'D';
        //Meses-Fondo de Salarios
        /*foreach ($datos['divisionSalarioMes'] as $salarioMes) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($columna++ . '16', $salarioMes['totalSalarioDivisionMes']);
        }*/

        //Apertura-Fondo de Salarios
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C16', '=SUM(D16:O16)/12');

        //Contenido-Fila Salario Medio Mensual
        //Total año
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B10', '=(B16/B8)/12');

        //Apertura-Salario Medio Mensual
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C10', '=(C16/C8)/12');

        //Meses-Salario Medio Mensual
        for ($i = 'D'; $i <= 'O'; $i++) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '10', '=(' . $i . '16/' . $i . '8)/12');
        }

        //Contenido-Fila Gasto de Salario ps Venta
        //Total año
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B11', '=(B16/B7)/12');

        //Apertura- Gasto de Salario ps Venta
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C11', '=(C16/C7)/12');

        //Meses-Gasto de Salario ps Venta
        for ($i = 'D'; $i <= 'O'; $i++) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '11', '=(' . $i . '16/' . $i . '7)/12');
        }

        //Formato del titulo y los encabezados
        $objPHPExcel->getActiveSheet()->getStyle('A5:O25')->applyFromArray($this->estiloDatosPlan());
        $objPHPExcel->getActiveSheet()->getStyle('A2:O5')->applyFromArray($this->estiloNegritasPlan());
        $objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray($this->estiloNegritasPlan());
        $objPHPExcel->getActiveSheet()->getStyle('B5:O5')->applyFromArray($this->estiloCenter());
        $objPHPExcel->getActiveSheet()->getStyle('A3:A3')->getFont()->getColor()->setARGB('456fdb');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B3:F3');
        $objPHPExcel->getActiveSheet()->getStyle('B3:F3')->getFont()->getColor()->setARGB('e2091d');
        /*$objPHPExcel->getActiveSheet()->getStyle('B9:O9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
        $objPHPExcel->getActiveSheet()->getStyle('B11:O19')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');*/

        //Tamaño de las celdas
        for ($i = 'A'; $i <= 'O'; $i++) {
            if ($i === 'A') {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(35);
            } else {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
            }
        }

        //Formato de numero sin posicion decimal y separador de miles con la coma
        for ($i = 'B'; $i <= 'O'; $i++) {
            for ($j = 7; $j <= 25; $j++) {
                $objPHPExcel->getActiveSheet()->getStyle($i . $j)->getNumberFormat()->setFormatCode('#,##0');
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle($datos['divisionVenta'][0]['division']);

        //inicio del codigo que crea las hojas por cada division
        foreach ($datos['centrosCostosVenta'] as $centro) {

            $objPHPExcel->createSheet();
            $activeSheet++;
            $objPHPExcel->setActiveSheetIndex($activeSheet);

            //titulo
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A2', 'EMPRESA: ECODIC');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A3', $centro['centro']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B3', 'APERTURA MENSUAL PLAN INDICADORES PRINCIPALES');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A4', 'AÑO ' . $year);

            //Encabezados verticales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A6', 'INDICADORES');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B5', 'TOTAL AÑO');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C5', 'APERTURA');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D5', 'Enero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E5', 'Febrero');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F5', 'Marzo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('G5', 'Abril');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('H5', 'Mayo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('I5', 'Junio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('J5', 'Julio');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('K5', 'Agosto');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('L5', 'Septiembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('M5', 'Octubre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('N5', 'Noviembre');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('O5', 'Diciembre');

            $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0, 6);

            //Encabezados horizontales
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A7', 'Ventas Totales');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A8', 'Promedio de Trabajadores');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A9', 'Productividad / Ventas');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A10', 'Salario Medio Mensual');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A11', 'Gasto de Salario ps Venta');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A12', 'Gasto Total');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A13', 'De ellos : Costo de Venta');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A14', 'Utilidad');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A15', 'Gasto de Fuerza de Trabajo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A16', 'Fondo de Salarios');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A17', 'Seguridad Social');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A18', 'Impuesto de la Fuerza de Trabajo');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A19', 'Gasto Material');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A20', 'Materias Primas');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A21', 'Combustibles y Lubricantes');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A22', 'Energia');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A23', 'Depreciacion  AFT');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A24', 'Amortizacion  AFT');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A25', 'Otros Gastos');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A26', 'Servicios recibidos');

            //Impresión de los servicios recibidos q no son todos los otros gastos monetarios

            $fila = 27;

            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Productividad / V.Agregado');
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Gasto Salario ps Prod. Mercantil');
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Gasto Salario ps V.Agregado');
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Valor Agregado');
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, 'Gasto Total/Ingreso Total');
            $fila++;

            //Contenido-Fila Ventas Totales
            //Total año
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B7', $centro['totalVentaCentroCosto']);

            $columna = 'D';
            //Meses-Ventas
            foreach ($datos['centrosCostosVentaMes'] as $ventaMes) {
                if ($centro['centro'] === $ventaMes['centro']) {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($columna++ . '7', $ventaMes['totalVentaCentroCostoMes']);
                }
            }

            //Apertura-Ventas
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C7', '=SUM(D7:O7)');

            //Contenido-Fila Promedio de trabajadores
            //Total año
            //$objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B8', $centro['centrosCostosSalario'][0]['totalPromedioTrabajadorCentroCosto']);

            $columna = 'D';
            //Meses-Promedio de trabajadores
            /*foreach ($centro['centrosCostosSalarioMes'] as $salarioMes) {
                if ($centro['centro'] === $salarioMes['centro']) {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($columna++ . '8', $salarioMes['totalPromedioTrabajadorCentroCostoMes']);
                }
            }*/

            //Apertura-Promedio de trabajadores
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C8', '=SUM(D8:O8)/12');

            //Contenido-Fila Productividad / Ventas
            //Total año
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B9', '=(B7/B8)/12');

            //Apertura-Productividad / Ventas
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C9', '=(C7/C8)/12');

            //Meses-Productividad / Ventas
            for ($i = 'D'; $i <= 'O'; $i++) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '9', '=(' . $i . '7/' . $i . '8)/12');
            }

            //Contenido-Fila Fondo de Salarios
            //Total año
            //$objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B16', $centro['centrosCostosSalario'][0]['totalSalarioCentroCosto']);

            $columna = 'D';
            //Meses-Fondo de Salarios
            /*foreach ($centro['centrosCostosSalarioMes'] as $salarioMes) {
                if ($centro['centro'] === $salarioMes['centro']) {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($columna++ . '16', $salarioMes['totalSalarioMedioCentroCostoMes']);
                }
            }*/

            //Apertura-Fondo de Salarios
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C16', '=SUM(D16:O16)/12');

            //Contenido-Fila Salario Medio Mensual
            //Total año
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B10', '=(B16/B8)/12');

            //Apertura-Salario Medio Mensual
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C10', '=(C16/C8)/12');

            //Meses-Salario Medio Mensual
            for ($i = 'D'; $i <= 'O'; $i++) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '10', '=(' . $i . '16/' . $i . '8)/12');
            }

            //Contenido-Fila Gasto de Salario ps Venta
            //Total año
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B11', '=(B16/B7)/12');

            //Apertura- Gasto de Salario ps Venta
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C11', '=(C16/C7)/12');

            //Meses-Gasto de Salario ps Venta
            for ($i = 'D'; $i <= 'O'; $i++) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue($i . '11', '=(' . $i . '16/' . $i . '7)/12');
            }

            //Formato del titulo y los encabezados
            $objPHPExcel->getActiveSheet()->getStyle('A5:O25')->applyFromArray($this->estiloDatosPlan());
            $objPHPExcel->getActiveSheet()->getStyle('A2:O5')->applyFromArray($this->estiloNegritasPlan());
            $objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray($this->estiloNegritasPlan());
            $objPHPExcel->getActiveSheet()->getStyle('B5:O5')->applyFromArray($this->estiloCenter());
            $objPHPExcel->getActiveSheet()->getStyle('A3:A3')->getFont()->getColor()->setARGB('456fdb');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->mergeCells('B3:F3');
            $objPHPExcel->getActiveSheet()->getStyle('B3:F3')->getFont()->getColor()->setARGB('e2091d');
            /*$objPHPExcel->getActiveSheet()->getStyle('B9:O9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');
            $objPHPExcel->getActiveSheet()->getStyle('B11:O19')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffb4b4');*/

            //Tamaño de las celdas
            for ($i = 'A'; $i <= 'O'; $i++) {
                if ($i === 'A') {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(35);
                } else {
                    $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setWidth(12);
                }
            }

            //Formato de numero sin posicion decimal y separador de miles con la coma
            for ($i = 'B'; $i <= 'O'; $i++) {
                for ($j = 7; $j <= 25; $j++) {
                    $objPHPExcel->getActiveSheet()->getStyle($i . $j)->getNumberFormat()->setFormatCode('#,##0');
                }
            }

            $objPHPExcel->getActiveSheet()->setTitle($centro['centro']);

        }

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Plan Estimado Division.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarDatosListados($titulo, $subtitulo, $encabezados, $valores, $nombres)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->
        getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy($nombres)
            ->setTitle($titulo)
            ->setSubject($subtitulo)
            ->setDescription("Documento generado con CONTFIN")
            ->setKeywords("CONTFIN")
            ->setCategory("LISTADOS");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $titulo);


        $i = 3;
        foreach ($encabezados as $clave => $valor) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $clave . ':');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, $valor);
            $i++;
        }
        $i--;

        $estiloEncabezado = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '#e95e25'
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('B3:B' . $i)->applyFromArray($estiloEncabezado);


        $lastColumn = 'A';
        $fila = $i + 2;
        $i = 1;

        foreach ($valores[0] as $clave => $valor) {

            $dato = $clave;

            if ($clave == 'No') $dato = 'No Expediente';
            if ($clave == 'Administrador') $dato = 'Administrador del Crédito';

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $fila, $dato);
            if ($i != count($valores[0])) $lastColumn++;
            $i++;
        }

        $estiloCampos = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '#222222'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#E95E25')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_THIN
                )

            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $cadena = $lastColumn;
        $cadena .= $fila;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':' . $cadena)->applyFromArray($estiloCampos);

        $fila++;
        $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, $fila);

        $inicioInfo = $fila;

        foreach ($valores as $valor) {

            $column = 1;

            foreach ($valor as $clave => $value) {

                $dato = $value;

                if ($clave == 'Fecha') $dato = $value->format('Y-m-d');
                if ($clave == 'No') {
                    $year = $valor['Fecha']->format('Y');
                    $dato = $year . ' - ' . $value;
                }
                if ($clave == 'Monto') {
                    $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
                    $dato = $fmt->format($value);
                    $array = explode(',', $dato);
                    $dato = $array[0] . ' XAF';
                }

                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($column, $fila, $dato);
                $column++;
            }
            $fila++;
        }

        $estiloTituloReporte = array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 16,
                'color' => array(
                    'rgb' => '111111'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#e95e25')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER_CONTINUOUS,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $lastColumn . '1')->applyFromArray($estiloTituloReporte);

        $estiloInformacion = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 10,
                'color' => array(
                    'rgb' => '222222'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_MEDIUM
                )

            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $cadena = $lastColumn;
        $cadena .= ($fila - 1);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $inicioInfo . ':' . $cadena)->applyFromArray($estiloInformacion);


        for ($j = 'A'; $j <= $lastColumn; $j++) {

            if ($j !== 'C') {
                $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setAutoSize(true);
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setWidth(50);
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $lastColumn . '1');


        $objPHPExcel->getActiveSheet()->setTitle($subtitulo);

        $objPHPExcel->setActiveSheetIndex(0);


        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $subtitulo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;
    }

    public function exportarDatosMandamientosPagos($titulo, $subtitulo, $encabezados, $expedientes, $nombres)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->
        getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy($nombres)
            ->setTitle($titulo)
            ->setSubject($subtitulo)
            ->setDescription("Documento generado con CONTFIN")
            ->setKeywords("CONTFIN")
            ->setCategory("LISTADOS");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $titulo);


        $i = 3;
        foreach ($encabezados as $clave => $valor) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $clave . ':');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, $valor);
            $i++;
        }
        $i--;

        $estiloEncabezado = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '#e95e25'
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('B3:B' . $i)->applyFromArray($estiloEncabezado);


        $lastColumn = 'F';
        $fila = $i + 2;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $fila, 'Fecha');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $fila, 'No Expediente');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $fila, 'Beneficiario');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $fila, 'Administrador del Crédito');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $fila, 'Monto');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, $fila, 'Estado');


        $estiloCampos = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '#222222'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#E95E25')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_THIN
                )

            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $cadena = $lastColumn;
        $cadena .= $fila;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':' . $cadena)->applyFromArray($estiloCampos);

        $fila++;
        $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, $fila);

        $inicioInfo = $fila;

        foreach ($expedientes as $expediente) {

            $fecha = $expediente->getFechaentrada()->format('Y-m-d');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $fila, $fecha);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $fila, $expediente->getNumeroExpedienteMostrar());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $fila, $expediente->getBeneficiario());
            $seccion = $expediente->getSeccion()->getNombreseccion();
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $fila, $seccion);
            $mandamientosPagos = $expediente->getMandamientosPagos();
            $lastMandamiento = $mandamientosPagos[count($mandamientosPagos) - 1];
            $monto = $lastMandamiento->getImportemandamientopago();
            $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
            $dato = $fmt->format($monto);
            $array = explode(',', $dato);
            $dato = $array[0] . ' XAF';
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $fila, $dato);
            $estado = $expediente->getEstadoexpedienteinstancia()->getEstadoexpediente();
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, $fila, $estado->getNombreestado());
            $fila++;
        }

        $estiloTituloReporte = array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 16,
                'color' => array(
                    'rgb' => '111111'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#e95e25')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER_CONTINUOUS,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $lastColumn . '1')->applyFromArray($estiloTituloReporte);

        $estiloInformacion = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 10,
                'color' => array(
                    'rgb' => '222222'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_MEDIUM
                )

            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $cadena = $lastColumn;
        $cadena .= ($fila - 1);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $inicioInfo . ':' . $cadena)->applyFromArray($estiloInformacion);


        for ($j = 'A'; $j <= $lastColumn; $j++) {

            if ($j !== 'C') {
                $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setAutoSize(true);
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setWidth(50);
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $lastColumn . '1');


        $objPHPExcel->getActiveSheet()->setTitle($subtitulo);

        $objPHPExcel->setActiveSheetIndex(0);


        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $subtitulo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;
    }

    public function exportarLeyPresupuesto($titulo, $subtitulo, $encabezados, $presupuestos, $nombres, $servicios, $presupuestoTotalV)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->
        getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy($nombres)
            ->setTitle($titulo)
            ->setSubject($subtitulo)
            ->setDescription("Documento generado con CONTFIN")
            ->setKeywords("CONTFIN")
            ->setCategory("LISTADOS");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $titulo);

        $i = 3;
        foreach ($encabezados as $clave => $valor) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $clave . ':');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, $valor);
            $i++;
        }
        $i--;

        $estiloEncabezado = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '#e95e25'
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('B3:B' . $i)->applyFromArray($estiloEncabezado);

        $lastColumn = 'A';
        $fila = $i + 2;
        $i = 1;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $fila, 'NE');
        foreach ($servicios as $servicio) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i + 1, $fila, 'Serv' . $servicio->getCodigoservicio());
            if ($i != count($servicios) + 1) $lastColumn++;
            $i++;
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i + 1, $fila, 'TOTAL');

        $estiloCampos = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '#222222'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#E95E25')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_THIN
                )

            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $lastColumn++;
        $cadena = $lastColumn;
        $cadena .= $fila;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':' . $cadena)->applyFromArray($estiloCampos);

        $fila++;
        $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, $fila);

        $inicioInfo = $fila;
        $col = 1;
        $fila--;
        $codigoNE = '';
        $pos = 0;
        $totalH = 0;
        While ($pos < count($presupuestos)) {

            if ($codigoNE == $presupuestos[$pos]['codigonumeroeconomico']) {
                $col++;
                $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
                $dato = $fmt->format($presupuestos[$pos]['Disponibilidad']);
                $array = explode(',', $dato);
                $dato = $array[0] . ' XAF';
                $totalH += $presupuestos[$pos]['Disponibilidad'];
                $pos++;
            } else {
                if ($codigoNE != '') {
                    $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
                    $total = $fmt->format($totalH);
                    $array = explode(',', $total);
                    $total = $array[0] . ' XAF';
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col + 1, $fila, $total);
                    $totalH = 0;
                }
                $col = 1;
                $fila++;
                $codigoNE = $presupuestos[$pos]['codigonumeroeconomico'];
                $dato = $presupuestos[$pos]['codigonumeroeconomico'];
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $fila, $dato);
        }
        $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        $total = $fmt->format($totalH);
        $array = explode(',', $total);
        $total = $array[0] . ' XAF';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col + 1, $fila, $total);

        $col = 1;
        $fila++;
        $totalGeneral = 0;
        $pos = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $fila, 'TOTAL');

        While ($pos < count($presupuestoTotalV)) {
            $col++;
            $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
            $dato = $fmt->format($presupuestoTotalV[$pos]['Disponibilidad']);
            $array = explode(',', $dato);
            $dato = $array[0] . ' XAF';
            $totalGeneral += $presupuestoTotalV[$pos]['Disponibilidad'];
            $pos++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $fila, $dato);
        }

        $fmt = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        $total = $fmt->format($totalGeneral);
        $array = explode(',', $total);
        $total = $array[0] . ' XAF';
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col + 1, $fila, $total);

        $estiloTituloReporte = array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 16,
                'color' => array(
                    'rgb' => '111111'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#e95e25')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER_CONTINUOUS,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $lastColumn . '1')->applyFromArray($estiloTituloReporte);

        $estiloInformacion = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 10,
                'color' => array(
                    'rgb' => '222222'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_MEDIUM
                )

            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $cadena = $lastColumn;
        $cadena .= $fila;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $inicioInfo . ':' . $cadena)->applyFromArray($estiloInformacion);


        for ($j = 'A'; $j <= $lastColumn; $j++) {

            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($j)->setAutoSize(true);
        }
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $lastColumn . '1');


        $objPHPExcel->getActiveSheet()->setTitle($subtitulo);

        $objPHPExcel->setActiveSheetIndex(0);


        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $subtitulo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    public function exportarPresupuestoSeccionCompleto($titulo, $seccion, $totalPresupuestosServiciosSeccion, $compromisoSeccion, $presupuestosServiciosSeccion, $datosServicios)
    {
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()
            ->setCreator("YADRIAN y ALAIN")
            ->setLastModifiedBy("CONTFIN")
            ->setTitle($titulo)
            ->setSubject($titulo)
            ->setDescription("Documento generado con CONTFIN")
            ->setKeywords("CONTFIN")
            ->setCategory("REPORTES");

        //inicio del codigo de la hoja general de la seccion
        $activeSheet = 0;

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B1', 'Presupuesto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C1', 'Disponibilidad');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D1', 'Compromiso');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E1', 'Liquidez');

        $styleEncabezados = [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'size' => 12,
                'color' => array(
                    'rgb' => '#e95e25'
                )
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $objPHPExcel->getActiveSheet()->getStyle('A1:E2')->applyFromArray($styleEncabezados);

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A2', $seccion->getNombreseccion());

        $objPHPExcel->getActiveSheet()->getCell('B2')->setValueExplicit(
            $totalPresupuestosServiciosSeccion['Presupuesto'],
            DataType::TYPE_NUMERIC
        );
        $objPHPExcel->getActiveSheet()->getCell('C2')->setValueExplicit(
            $totalPresupuestosServiciosSeccion['Disponibilidad'],
            DataType::TYPE_NUMERIC
        );
        $objPHPExcel->getActiveSheet()->getCell('D2')->setValueExplicit(
            $compromisoSeccion / 1000,
            DataType::TYPE_NUMERIC
        );
        $objPHPExcel->getActiveSheet()->getCell('E2')->setValueExplicit(
            $totalPresupuestosServiciosSeccion['Liquidez'],
            DataType::TYPE_NUMERIC
        );

        $styleDatosNumericos = [
            'numberFormat' => [
                'formatCode' => NumberFormat::FORMAT_CURRENCY_XAF,
            ],
            'font' => [
                'name' => 'Arial',
                'size' => 10,
                'color' => array(
                    'rgb' => '#e95e25'
                )
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $styleDatosTexto = [
            'font' => [
                'name' => 'Arial',
                'size' => 10,
                'color' => array(
                    'rgb' => '#e95e25'
                )
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $styleTotales = [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'size' => 12,
                'color' => array(
                    'rgb' => '#e95e25'
                )
            ],
        ];


        $objPHPExcel->getActiveSheet()->getStyle('B2:E2')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->getStyle('B2:E2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        for ($i = 'A'; $i <= 'E'; $i++) {

            $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Sección');

        //fin del codigo de la hoja general de la seccion

        //inicio del codigo de la hoja de distibucion por servicios

        $objPHPExcel->createSheet();
        $activeSheet++;
        $objPHPExcel->setActiveSheetIndex($activeSheet);

        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A1', 'Código Servicio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B1', 'Nombre Servicio');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C1', 'Presupuesto');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D1', 'Disponibilidad');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E1', 'Compromiso');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F1', 'Liquidez');

        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleEncabezados);

        $fila = 2;
        foreach ($presupuestosServiciosSeccion as $servicio) {
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, $servicio['codigoservicio']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $servicio['nombreservicio']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $servicio['Presupuesto']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $servicio['Disponibilidad']);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $servicio['compromiso'] / 1000);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $servicio['Liquidez']);
            $fila++;
        }
        $fila++;
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'TOTAL');
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $totalPresupuestosServiciosSeccion['Presupuesto']);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $totalPresupuestosServiciosSeccion['Disponibilidad']);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $compromisoSeccion / 1000);
        $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $totalPresupuestosServiciosSeccion['Liquidez']);

        $objPHPExcel->getActiveSheet()->getStyle('A2:B' . $fila)->applyFromArray($styleDatosTexto);
        $objPHPExcel->getActiveSheet()->getStyle('C2:F' . $fila)->applyFromArray($styleDatosNumericos);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':F' . $fila)->applyFromArray($styleTotales);

        for ($i = 'A'; $i <= 'F'; $i++) {

            $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Servicios');

        //fin del codigo de la hoja de distibucion por servicios

        //inicio del codigo que crea las hojas por cada servicio
        foreach ($datosServicios as $dato) {
            $objPHPExcel->createSheet();
            $activeSheet++;
            $objPHPExcel->setActiveSheetIndex($activeSheet);

            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A1', 'Código Número Económico');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B1', 'Nombre Número Económico');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C1', 'Presupuesto');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D1', 'Disponibilidad');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E1', 'Compromiso');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F1', 'Liquidez');

            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleEncabezados);

            $fila = 2;
            $presupuestoTotalServicio = 0;
            $disponibilidadTotalServicio = 0;
            $compromisoTotalServicio = 0;
            $liquidezTotalServicio = 0;
            foreach ($dato['presupuestosServicios'] as $presupuesto) {
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('A' . $fila, $presupuesto['codigonumeroeconomico']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, $presupuesto['nombrenumeroeconomico']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $presupuesto['Presupuesto']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $presupuesto['Disponibilidad']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $presupuesto['compromiso']);
                $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $presupuesto['Liquidez']);
                $presupuestoTotalServicio += $presupuesto['Presupuesto'];
                $disponibilidadTotalServicio += $presupuesto['Disponibilidad'];
                $compromisoTotalServicio += $presupuesto['compromiso'];
                $liquidezTotalServicio += $presupuesto['Liquidez'];
                $fila++;
            }
            $fila++;
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('B' . $fila, 'TOTAL');
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('C' . $fila, $presupuestoTotalServicio);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('D' . $fila, $disponibilidadTotalServicio);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('E' . $fila, $compromisoTotalServicio);
            $objPHPExcel->setActiveSheetIndex($activeSheet)->setCellValue('F' . $fila, $liquidezTotalServicio);

            $objPHPExcel->getActiveSheet()->getStyle('A2:B' . $fila)->applyFromArray($styleDatosTexto);
            $objPHPExcel->getActiveSheet()->getStyle('C2:F' . $fila)->applyFromArray($styleDatosNumericos);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $fila . ':F' . $fila)->applyFromArray($styleTotales);

            $objPHPExcel->getActiveSheet()->setTitle('Presupuesto Servicio' . $dato['codigoServicio']);

            for ($i = 'A'; $i <= 'F'; $i++) {

                $objPHPExcel->setActiveSheetIndex($activeSheet)->getColumnDimension($i)->setAutoSize(true);
            }
        }

        //fin del codigo que crea las hojas por cada servicio


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Sección' . $seccion->getCodigoseccion() . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($objPHPExcel);
        $writer->save('php://output');

        exit;

    }

    //Estilos
    private function estiloEncabezadosColumnas()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => [
                    'rgb' => '#222222'
                ]
            ],
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            ]
        ];


    }

    private function estiloEncabezadosColumnasMenor()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 10,
                'color' => [
                    'rgb' => '#222222'
                ]
            ],
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            ]
        ];


    }

    private function estiloCenter()
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            ]
        ];


    }

    private function estiloNegritas()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => [
                    'rgb' => '#222222'
                ]
            ]
        ];


    }

    private function estiloNegritasPlan()
    {
        return [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '#222222'
                ]
            ]
        ];


    }

    private function estiloColorFontRed()
    {
        return [
            'font' => [
                'bold' => false,
                'color' => [
                    'rgb' => '#222222'
                ]
            ]
        ];


    }

    private function estiloTituloReporte()
    {
        return array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '111111'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#e95e25')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_MEDIUM,
                    'color' => array('argb' => '000000')
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER_CONTINUOUS,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
    }

    private function estiloTituloReporteVenta()
    {
        return array(
            'font' => array(
                'name' => 'Century Gothic',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 20,
                'color' => array(
                    'rgb' => '111111'
                )
            ),
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '#ffffff')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_MEDIUM,
                    'color' => array('argb' => '000000')
                )
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER_CONTINUOUS,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
    }

    private function estiloEncabezadosColumnasVenta()
    {
        return [
            'font' => [
                'name' => 'Century Gothic',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 11,
                'color' => [
                    'rgb' => '#222222'
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            ]
        ];


    }

    private function estiloDatos()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => [
                    'rgb' => '#222222'
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            ]
        ];
    }

    private function estiloDatosPlan()
    {
        return [
            'font' => [
                'name' => 'Century Gothic',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 10,
                'color' => [
                    'rgb' => '#222222'
                ]
            ]
        ];
    }

    private function estiloBordes()
    {
        return [
            'font' => [
                'name' => 'Arial',
                'size' => 10,
                'color' => [
                    'rgb' => '#222222'
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ]
        ];
    }

    private function estiloBordesVentas()
    {
        return [
            'font' => [
                'name' => 'Century Gothic',
                'size' => 11,
                'color' => [
                    'rgb' => '#222222'
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ]
        ];
    }


}