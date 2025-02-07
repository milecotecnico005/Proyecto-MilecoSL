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
use Illuminate\Support\Facades\Auth;

class PagosCobrosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
