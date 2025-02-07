<?php

namespace App\Exports;

use App\Models\PartesTrabajo;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Modelo347Export implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{

    private $cliente_id;

    public function __construct($cliente_id)
    {
        $this->cliente_id = $cliente_id;
    }

    public function collection()
    {
        return PartesTrabajo::with(['cliente', 'partesTrabajoLineas'])
        ->when($this->cliente_id, function ($query, $cliente_id) {
            return $query->where('cliente_id', $cliente_id);
        })
        ->get();
    }

    public function headings(): array
    {
        return [
            'Parte',
            'Cliente',
            'Asunto',
            'Fecha Alta',
            'Estado',
            'Total Parte (€)',
            'Saldo Cobrado (€)',
            'Saldo Pendiente (€)',
            'Enlace PDF',
        ];
    }

    public function map($parte): array
    {
        $saldoCobrado = $parte->partesTrabajoLineas->where('venta_id', '!=', null)->sum('total');
        $saldoPendiente = $parte->totalParte - $saldoCobrado;

        $tituloParte = ($parte->tituloParte) ? $parte->tituloParte : $parte->Asunto;

        // Generar URL firmada para el PDF
        $signedUrl = URL::signedRoute('admin.modelo347.descargarPdf', ['idParteTrabajo' => $parte->idParteTrabajo]);

        return [
            $parte->idParteTrabajo,
            $parte->cliente->NombreCliente ?? 'Sin Cliente',
            $tituloParte,
            $parte->FechaAlta,
            $parte->Estado,
            $parte->totalParte,
            $saldoCobrado,
            $saldoPendiente,
            $signedUrl, // Enlace real en la columna J
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Aplicar estilo al encabezado
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4CAF50'],
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
            // Estilo de la celda de "Enlace PDF" (columna J)
            'I' => [
                'font' => [
                    'color' => ['rgb' => '0000FF'], // Azul para el enlace
                    'underline' => true, // Subrayado
                ],
            ],
        ];
    }

    public function afterSheet(Worksheet $sheet){
        $rows = $sheet->getHighestRow(); // Obtener la última fila con datos
        for ($row = 2; $row <= $rows; $row++) {
            // Obtener la URL de la columna J y convertirla en un hipervínculo
            $cell = "J{$row}";
            $url = $sheet->getCell($cell)->getValue();

            // Usar la función HYPERLINK para establecer el texto y el enlace
            $sheet->setCellValue($cell, '=HYPERLINK("' . $url . '", "Descargar PDF")');
        }
    }
}


