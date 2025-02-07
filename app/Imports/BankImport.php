<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\banco_detail;

class BankImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        if (is_numeric($row['fecha_operacion'])) {
            $row['fecha_operacion'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_operacion']);
        }

        if (is_numeric($row['fecha_valor'])) {
            $row['fecha_valor'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_valor']);
        }

        if (is_numeric($row['fecha_alta'])) {
            $row['fecha_alta'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_alta']);
        }

        return banco_detail::create([
            'plazo_id'       => $row['plazos'] ?? null,
            'fecha_operacion'=> $row['fecha_operacion'],
            'concepto'       => $row['concepto'],
            'fecha_valor'    => $row['fecha_valor'],
            'importe'        => $row['importe'],
            'saldo'          => $row['saldo'],
            'banco_id'       => $row['banco'],
            'empresa_id'     => $row['empresa'],
            'notas1'         => $row['notas1'],
            'notas2'         => $row['notas2'],
            'notas3'         => $row['notas3'],
            'notas4'         => $row['notas4'],
            'fecha_alta'     => $row['fecha_alta'],
            'venta_id'       => $row['venta_id'],
            'compra_id'      => $row['compra_id'],
        ]);
    }
}
