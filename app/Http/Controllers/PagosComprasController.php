<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banco;
use App\Models\Compra;
use App\Models\Empresa;
use App\Models\PagosCompras;
use App\Models\Proveedor;
use App\Models\Ventas;
use Illuminate\Http\Request;

class PagosComprasController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){

        $pagoscompras = PagosCompras::all();
        $proveedores  = Proveedor::all();
        $bancos       = Banco::all();
        $empresas     = Empresa::all();
        $compras      = Compra::all();
        $ventas       = Ventas::whereHas('ventaLineas.parteTrabajo', function ($query) {
            $query->whereNotNull('parte_trabajo');
        })->get();
        
        return view('admin.pagoscompras.index', compact(
            'pagoscompras',
            'proveedores',
            'bancos',
            'empresas',
            'compras',
            'ventas'
            )
        );
    }

    public function store(Request $request)
    {
        try {
            dd($request->all());
            $request->validate([
                'fechaPago'         => 'required|date',
                'Importe'           => 'required',
                'proveedor_id'      => 'required|exists:proveedores,idproveedor',
                'banco_id'          => 'required|exists:bancos,idbanco',
                'empresa_id'        => 'required|exists:empresas,idempresa',
                'compra'            => 'required|exists:compras,idcompra',
                'observacionesPago' => 'nullable',
                'NAsientoContable'  => 'nullable'
            ]);

            PagosCompras::create([
                'fechaPago'         => $request->fechaPago,
                'montoPago'         => $request->montoPago,
                'proveedor'         => $request->proveedor,
                'banco'             => $request->banco,
                'empresa'           => $request->empresa,
                'compra'            => $request->compra,
                'observacionesPago' => $request->observacionesPago
            ]);

            return redirect()->route('admin.pagoscompras.index')->with('success', 'Pago de compra creado exitosamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.pagoscompras.index')->with('error', 'Error al crear el pago de compra');
        }
    }

}
