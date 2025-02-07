<?php

namespace App\Imports;

use App\Models\Cliente;
use App\Models\TelefonosClientes;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class ClientesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            // Recorremos todas las filas del archivo (omitimos la primera fila si contiene encabezados)
            foreach ($rows as $index => $row) {

                if ($index === 0) {
                    continue; // Omitir la primera fila (encabezados)
                }

                // Crear el cliente
                $cliente = Cliente::create([
                    'CIF'               => $row[0],
                    'NombreCliente'     => $row[1],
                    'ApellidoCliente'   => $row[2],
                    'Direccion'         => $row[3],
                    'CodPostalCliente'  => $row[4],
                    'ciudad_id'         => $row[5],
                    'EmailCliente'      => $row[6],
                    'Agente'            => ( $row[7] ) ? $row[7] : null, // Agente opcional
                    'TipoClienteId'     => $row[8],
                    'banco_id'          => $row[9],
                    'SctaContable'      => ( $row[10] ) ? $row[10] : null, // Opcional
                    'Observaciones'     => ( $row[11] ) ? $row[11] : null, // Opcional
                    'user_id'           => null
                ]);

                // Los teléfonos se pueden enviar como un string separado por comas (ej. "123456789,987654321")
                $telefonos = explode(',', $row[8]); // Asegúrate de que la columna 12 contenga los teléfonos separados por comas
                foreach ($telefonos as $telefono) {
                    TelefonosClientes::create([
                        'Clientes_idClientes' => $cliente->idClientes,
                        'telefono' => trim($telefono)
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
