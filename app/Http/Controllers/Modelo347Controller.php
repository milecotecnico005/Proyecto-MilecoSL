<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Modelo347Export;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Modelo347Controller extends Controller
{
    public function index()
    {
        $limite = Configuracion::where('clave', 'modelo_347_limite')->value('valor');
        $limite = (int) $limite;
        $ventas = Ventas::with('cliente', 'empresa')
            ->selectRaw(
                'QUARTER(ventas_sl.FechaVenta) as trimestre,
                ventas_sl.cliente_id,
                ventas_sl.empresa_id,
                ventas_sl.tipo_movimiento,
                ventas_sl.notasmodelo347,
                ventas_sl.correo,
                ventas_sl.agente,
                SUM(ventas_sl.TotalFacturaVenta) as total'
            )
            ->groupBy(
                'cliente_id',
                'trimestre',
                'empresa_id',
                'tipo_movimiento',
                'notasmodelo347',
                'correo',
                'agente'
            )
            ->havingRaw('SUM(ventas_sl.TotalFacturaVenta) >= ?', [$limite])
            ->get();


        // generar un id único para cada registro
        $ventas->map(function ($venta) {
            $venta->id = $venta->cliente_id;

            $year  = Carbon::now()->year;

            $venta->year = $year;
            return $venta;
        });

        $clientes = Cliente::all();

        return view('admin.modelo347.index', compact('ventas', 'limite', 'clientes'));
    }

    public function actualizarLimite(Request $request)
    {
        try {
            $request->validate([
                'limite' => 'required|numeric|min:1'
            ]);
    
            DB::BeginTransaction();
    
            Configuracion::where('clave', 'modelo_347_limite')->update(['valor' => $request->limite]);
    
            DB::commit();
    
            return back()->with('success', 'Límite actualizado correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Ha ocurrido un error al actualizar el límite.' . $th->getMessage());
        }
    }

    public function enviarEmail(Request $request, $ventaId){
        $venta = Ventas::findOrFail($ventaId);

        // Validación del correo
        $request->validate([
            'correo' => 'required|email',
        ]);

        $correos = explode(',', $request->correo); // Permite enviar a múltiples destinatarios.

        // Contenido del email
        $data = [
            'cliente' => $venta->cliente->nombre,
            'empresa' => $venta->empresa->nombre,
            'total' => $venta->total,
            'notas1' => $venta->notas1,
            'agente' => $venta->agente,
        ];

        // Usa Mail::send() para enviar el correo
        try {
            Mail::send('emails.modelo347', $data, function ($message) use ($correos) {
                $message->to($correos)
                    ->subject('Información del Modelo 347');
            });

            return back()->with('success', 'Correo enviado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar el correo: ' . $e->getMessage());
        }
    }

    public function exportarExcel(Request $request){

        $cliente = $request->cliente_id;

        return Excel::download(new Modelo347Export($cliente), 'modelo347.xlsx');
    }

    public function descargarPdf($id){

        $partesController = new PartesTrabajoController();

        return $partesController->generarPdf($id);

    }

}
