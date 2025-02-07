<?php

namespace App\Exports;

use App\Models\ordentrabajo_operarios;
use App\Models\PartesTrabajo;
use App\Models\partesTrabajoArchivos;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParteTrabajoExport implements FromArray, WithHeadings, WithStyles
{
    protected $store;
    protected $storeLineas;
    protected $folderName;

    public function __construct(PartesTrabajo $store, $storeLineas, $folder)
    {
        $this->store        = $store;  // Instancia del Store (Parte de Trabajo)
        $this->storeLineas  = $storeLineas;  // Las líneas del store
        $this->folderName   = $folder; 
    }

    public function headings(): array{
        return [
            ['NUMERO:', $this->folderName, '', '', '', '', 'FOTOS:']
        ];
    }

    public function recortarTitle($title){
        $title = substr($title, 0, 70);
        return $title;
    }

    public function array(): array{
        $estado = ($this->store->Estado == 1) ? 'Pendiente' : (($this->store->Estado == 2) ? 'En Proceso' : 'Finalizado');
        
        // Definir las filas principales en la columna A, comenzando desde la fila 2
        $rows = [
            ['IDPROYECTO:', (isset($this->store->proyectoNMN) && count($this->store->proyectoNMN) > 0) ? $this->store->proyectoNMN[0]->proyecto->idProyecto : $this->store->idParteTrabajo, (isset($this->store->proyectoNMN) && count($this->store->proyectoNMN) > 0) ? $this->recortarTitle($this->store->proyectoNMN[0]->proyecto->name) : $this->recortarTitle($this->store->Asunto), '', '', '', ''],
            ['FECHA:', $this->store->FechaAlta, '', '', '', '', ''],
            ['CLIENTE:', '', $this->store->cliente->NombreCliente . " " . $this->store->cliente->ApellidoCliente, '', '', '', ''],
            ['HORA COMIENZO:', $this->store->hora_inicio, '', '', '', '', ''],
            ['HORA FINAL:', $this->store->hora_fin, '', '', '', '', ''],
            ['HORAS:', $this->store->horas_trabajadas, '', '', '', '', ''],
            ['TAREA:', $this->store->Asunto, '', '', '', '', ''],
            ['DESCRIPCION:', $this->store->solucion, '', '', '', '', ''],
            ['ESTADO:', $estado, '', '', '', '', ''],
            ['FECHA FIN:', $this->store->FechaVisita, '', '', '', '', ''],
            ['INFORME:', '', '', '', '', '', ''],
            ['', '', '', '', '', '', ''],
            ['', '', '', '', '', '', ''],
            [$this->getFirma(), '', '', '', '', '', ''],
            ['', '', '', '', '', '', ''],
            [$this->store->nombre_firmante, '', '', '', '', '', ''],
            ['', '', '', '', '', '', ''],
            ['', '', '', '', '', '', ''],
            [$this->getOperarios(), '', '', '', '', '', ''],
            ['', '', '', '', '', '', ''],
            ['DETALLE MAT:', '', '', 'SUMA MATERIALES-->', $this->store->suma],
            ['PRODUCTO:', 'CANTIDAD', 'PRECIO', 'D%', 'TOTAL'],
        ];

        $fila_inicio = 0;
        // Agregar las fotos y comentarios debajo de la cabecera "FOTOS" en la columna G
        foreach ($this->getFotos() as $key => $foto) {

            $rows[$fila_inicio][6] = $foto['path'];  // Cabecera "FOTOS" en la columna G
            $rows[$fila_inicio + 1][6] = $foto['comentario'];  // Comentario debajo

            $fila_inicio += 2;
        }

        // redondear las horas trabajadas si 1.5 hacia arriba 2.5 = 3, 3.5 = 4, 4.3 = 4.5
        $horas_trabajadas = round($this->store->horas_trabajadas * 2) / 2;
            
        // obtener el precio de la mano de obra oficial
        $operario = ordentrabajo_operarios::where('orden_id', $this->store->orden_id)->with('operarios')->first();

        $totalHorasTrabajadas = $horas_trabajadas * $operario->operarios->salario->salario_hora;

        // Validar si $parte->precio hora es mayor a $totalHorasTrabajadas debemos buscar el numero que multiplicado por $operario->operarios->salario->salario_hora sea igual a $parte->precio_hora
        if ($this->store->precio_hora > $totalHorasTrabajadas) {
            $horas_trabajadas = $this->store->precio_hora / $operario->operarios->salario->salario_hora;
        }

        // verificar si el $this->store->precio_hora puede ser 1.5 cantidad de horas trabajadas
        if ($this->store->precio_hora % $operario->operarios->salario->salario_hora == 0) {
            $horas_trabajadas = $this->store->precio_hora / $operario->operarios->salario->salario_hora;
        }

        $totalHorasTrabajadas = $horas_trabajadas * $operario->operarios->salario->salario_hora;

        // Calcular el porcentaje de descuento en base al precio de la mano de obra oficial
        if ($totalHorasTrabajadas > 0) {
            $descuento = (($totalHorasTrabajadas - $this->store->precio_hora) / $totalHorasTrabajadas) * 100;
        } else {
            $descuento = 0;
        }

        // Si el precio es igual al total de horas trabajadas, el descuento es 0, si es 0 significa 100% descuento
        if ($this->store->precio_hora == 0) {
            $descuento = 100;
        }

        $data = [
            "nombreArticulo" => "M.Obra oficial mantenimiento.",
            "cantidad" => $horas_trabajadas,
            "precioSinIva" => $operario->operarios->salario->salario_hora,
            "total" => $this->store->precio_hora,
            "descuento" => $descuento,
        ];


        $dataDesplazamiento = [
            "nombreArticulo" => "Desplazamiento",
            "cantidad" => 1,
            "precioSinIva" => $this->store->desplazamiento,
            "total" => $this->store->desplazamiento,
            "descuento" => 0,
        ];

        $this->store["partesTrabajoLineas"][] = $data;
        $this->store["partesTrabajoLineas"][] = $dataDesplazamiento;

        // Recorrer las líneas de parte de trabajo y agregar sus detalles
        foreach ($this->storeLineas as $linea) {
            
            // verificar si la linea es un array o un objeto
            if (is_array($linea)) {
                $linea = (object) $linea;
            }

            $rows[] = [
                $linea->articulo->nombreArticulo ?? $linea->nombreArticulo,  // Nombre del producto
                $linea->cantidad,                  // Cantidad del producto
                ($linea->precioSinIva == 0) ? '0' : $linea->precioSinIva,   // Precio del producto
                ($linea->descuento == 0) ? '0' : $linea->descuento,        // Descuento aplicado
                ($linea->total == 0) ? '0' : $linea->total,                     // Total
            ];

        }

        $rows[] = ['', '', '', '', ''];
        $rows[] = ['', '', '', '', ''];
        $rows[] = ['FINAL LISTADO', '', '', '', ''];

        return $rows;
    }


    private function getFotosWithComment(){
        $fotos = $this->getFotos();
        $fotosString = '';
        foreach ($fotos as $foto) {
            $fotosString .= $foto['comentario'] . " - " . $foto['path'] . ", ";
        }
        return $fotosString;
    }

    private function getOperarios(){
        $operarios = $this->store->orden->operarios;
        $operariosString = '';
        foreach ($operarios as $operario) {
            // validar si es el último operario para no agregar la coma
            if ($operario->idOperario == $operarios->last()->idOperario) {
                $operariosString .= $operario->nameOperario;
                break;
            }

            $operariosString .= $operario->nameOperario.", ";
        }
        return $operariosString;
    }

    private function getFirma(){
        // Obtener la firma asociada a este parte de trabajo
        $firma = partesTrabajoArchivos::where('parteTrabajo_id', $this->store->idParteTrabajo)
        ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', '=', 'archivos.idarchivos')
        ->WHERE('comentarioArchivo', 'LIKE', '%firma_digital_bd%')
        ->first();

        $firmaPath = $firma ? $this->folderName."/".$firma->nameFile : '';

        return $firmaPath;
    }

    private function getFotos()
    {
        // Obtener todas las fotos asociadas a este parte de trabajo
        $imagenes = PartesTrabajoArchivos::where('parteTrabajo_id', $this->store->idParteTrabajo)
            ->leftJoin('archivos', 'partestrabajo_sl_has_archivos.archivo_id', '=', 'archivos.idarchivos')
            ->WHERE('comentarioArchivo', 'NOT LIKE', '%firma_digital_bd%')
            ->get(['archivos.pathFile as path', 'partestrabajo_sl_has_archivos.comentarioArchivo as comentario', 'archivos.nameFile']);

        // Si quieres fotos con comentarios, retornas un array de arrays
        return $imagenes->map(function ($imagen) {
            $new = [
                'path' => $this->folderName."/".$imagen->nameFile,
                'comentario' => $imagen->comentario,
            ];
            return $new;
        })->toArray();
        
    }

    public function styles(Worksheet $sheet)
    {
        // Estilos opcionales, por ejemplo, poner la primera fila en negrita
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        
        // Estilo para la cabecera de fotos si existe
        $sheet->getStyle('A22:E22')->getFont()->setBold(true); // Asegúrate de que esta fila sea correcta.

        // Estilo para la fila A20, ajustar si es necesario
        $sheet->getStyle('A20')->getFont()->setBold(true);

        // Hacer más ancho la columna A
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(10);
        
        return [];
    }
}
