<?php

namespace App\Exports;

use App\Models\PartesTrabajo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TechniciansReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $fechaInicio;
    protected $fechaFin;
    protected $userIds;

    public function __construct(string $fechaInicio, string $fechaFin, array $userIds)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->userIds = $userIds;
    }

    public function collection(): Collection
    {
        $query = PartesTrabajo::query()
            ->with(['orden', 'cliente', 'partesTrabajoLineas.articulo'])
            ->whereBetween('FechaVisita', [$this->fechaInicio, $this->fechaFin]);

        if (!in_array(0, $this->userIds)) {
            $query->whereHas('orden.operarios', function ($q) {
                $q->whereIn('idOperario', $this->userIds);
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Técnico',
            'Titulo',
            'Fecha Visita',
            'Asunto',
            'Solución',
            'Cliente',
            'Hora Inicio',
            'Hora Fin',
            'Horas Trabajadas',
            'Precio por Hora',
            'Descuento Mano de Obra',
            'Total Precio Mano de Obra',
            'Total Del Parte',
            'Estado Facturación',
        ];
    }

    public function map($parte): array
    {
        $tecnico = $parte->orden->operarios->pluck('nameOperario')->join(', ');
        $nombreClienteCompleto = $parte->cliente->NombreCliente . ' ' . $parte->cliente->ApellidoCliente;
        $titulo = $parte->tituloParte ?? 'N/A';

        // Filtrar las líneas de mano de obra (categoría_id = 10)
        $manoDeObraLineas = $parte->partesTrabajoLineas->filter(function ($linea) {
            return $linea->articulo && $linea->articulo->categoria_id == 10;
        });

        // Calcular las horas trabajadas y el precio por hora
        $horasTrabajadas = $manoDeObraLineas->sum('cantidad');
        $totalManoDeObra = $manoDeObraLineas->sum(function ($linea) {
            $precioConDescuento = $linea->precioSinIva * (1 - ($linea->descuento / 100));
            return $precioConDescuento * $linea->cantidad;
        });
        $precioPorHora = $horasTrabajadas > 0 ? $totalManoDeObra / $horasTrabajadas : 0;

        // obtener el descuento de la mano de obra
        $descuentoManoDeObra = $parte->partesTrabajoLineas->filter(function ($linea) {
            return $linea->articulo && $linea->articulo->categoria_id == 10;
        })->sum('descuento');

        return [
            $tecnico,
            $titulo,
            formatDate($parte->FechaVisita),
            $parte->Asunto,
            $parte->solucion,
            $nombreClienteCompleto ?? 'N/A',
            $parte->hora_inicio,
            $parte->hora_fin,
            number_format($horasTrabajadas, 2), // Formatear a 2 decimales
            number_format($precioPorHora, 2),
            number_format($descuentoManoDeObra, 2),
            number_format($totalManoDeObra, 2),
            $parte->totalParte,
            ($parte->estadoVenta == 1) ? 'No Facturado' : 'Facturado',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilo para la cabecera
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
        ]);

        // Ajustar automáticamente el ancho de las columnas
        foreach (range('A', 'N') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // ajustar el alto de las filas
        $sheet->getDefaultRowDimension()->setRowHeight(20);

        return [];
    }
}
