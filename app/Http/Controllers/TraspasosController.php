<?php

namespace App\Http\Controllers;

use App\Models\Articulos;
use App\Models\ArticulosStock;
use App\Models\Empresa;
use App\Models\OrdenesTrabajo;
use App\Models\PartesTrabajo;
use App\Models\ProyectosPartes;
use App\Models\Traspasos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraspasosController extends Controller
{
    public function index()
    {
        $traspasos = Traspasos::all();
        $almacenes = Empresa::all();
        // los productos deben de tener stock
        $productos = Articulos::whereHas('stock', function($query){
            $query->where('cantidad', '>', 0);
        })
        ->WHERE('TrazabilidadArticulos', '!=', 'Proviene_Presupuesto_No_Facturado')
        ->WHERE('categoria_id', '!=', 8)
        ->with('stock',)->get();
        
        return view('admin.traspasos.index', compact('traspasos', 'almacenes', 'productos'));
    }

    public function store( Request $request ){
        try {

            DB::beginTransaction();

            $request->validate([
                'fecha' => 'required|date',
                'origen' => 'required|numeric',
                'destino' => 'required|numeric',
                'producto' => 'required|numeric',
                'cantidad' => 'required|numeric',
            ]);

            // restar la cantidad del producto en el almacen origen
            $producto = Articulos::find($request->producto);
            
            if( $producto->stock < $request->cantidad ){
                return redirect()->back()->with('error', 'No hay suficiente stock para realizar el traspaso');
            }
            $producto->save();

            $stock = ArticulosStock::where('articulo_id', $request->producto)->first();
            $stock->cantidad -= $request->cantidad;
            $stock->save();

            $articulo = Articulos::create([
                'categoria_id'          => $producto->categoria_id,
                'nombreArticulo'        => $producto->nombreArticulo,
                'ptsCosto'              => $producto->ptsCosto,
                'ptsVenta'              => $producto->ptsVenta,
                'Beneficio'             => $producto->Beneficio,
                'empresa_id'            => $request->destino,
                'proveedor_id'          => $producto->proveedor_id,
                'SubctaInicio'          => $producto->SubctaInicio,
                'TrazabilidadArticulos' => $producto->TrazabilidadArticulos,
                'Observaciones'         => $producto->Observaciones,
                'created_at'            => Carbon::now()->format('Y-m-d'),
                'updated_at'            => Carbon::now()->format('Y-m-d'),
                'compra_id'             => $producto->compra_id,
            ]);

            ArticulosStock::create([
                'articulo_id'       => $articulo->idArticulo,
                'ultimaCompraDate'  => Carbon::now()->format('Y-m-d'),
                'existenciasMin'    => 0,
                'cantidad'          => $request->cantidad,
                'existenciasMax'    => 0,
                'created_at'        => Carbon::now()->format('Y-m-d'),
                'updated_at'        => Carbon::now()->format('Y-m-d'),
            ]);
            
            $traspaso = Traspasos::create([
                'fecha_traspaso' => $request->fecha,
                'origen_id' => $request->origen,
                'destino_id' => $request->destino,
                'articulo_id' => $articulo->idArticulo,
                'articulo_traspasado' => $request->producto,
                'cantidad' => $request->cantidad,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Traspaso realizado correctamente');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function ticketPDF( $id ){
        try {
            
            $traspaso            = Traspasos::find($id);
            $origen              = Empresa::find($traspaso->origen_id);
            $destino             = Empresa::find($traspaso->destino_id);
            $producto            = Articulos::find($traspaso->articulo_id);
            $producto_traspasado = Articulos::find($traspaso->articulo_traspasado);
            $fechaHoy            = Carbon::now()->format('y-m-d');

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticketTraspaso', [
                'traspaso' => $traspaso,
                'origen' => $origen,
                'destino' => $destino,
                'producto' => $producto,
                'producto_traspasado' => $producto_traspasado,
                'fechaHoy' => $fechaHoy,
            ])->setPaper('a4', 'landscape');;

            // nombre del archivo
            $nombre = 'traspaso_'.$producto->nombreArticulo.'_'.$traspaso->id_traspaso.'_'.$fechaHoy.'.pdf';

            return $pdf->download($nombre);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}
