<?php

namespace App\Http\Controllers;

use App\Models\Archivos;
use App\Models\Articulos;
use App\Models\Banco;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\ComprasArchivo;
use App\Models\Empresa;
use App\Models\lineasCompras;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\PagosCompras;
use App\Models\PartesTrabajo;
use App\Models\Presupuestos;
use App\Models\Project;
use App\Models\Proveedor;
use App\Models\Trabajos;
use App\Models\User;
use App\Models\Ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // obtener valores para los graficos

        // ventas
        $ventas = Ventas::with(
            'cliente',
            'empresa',
            'plazo',
            'ventaLineas',
            'ventaConfirm'
        )->get();

        // Importaciones
        $projects = Project::all();
        $clientes = Cliente::all();
        $trabajos = Trabajos::all();
        $empresas = Empresa::all();
        $proveedores = Proveedor::all();
        $operarios = Operarios::all();
        $compras   = Compra::all();

        // Visualizar ordenes de trabajo
        $ordenes   = OrdenesTrabajo::orderBy('idOrdenTrabajo', 'desc')->with(
            'cliente',
            'trabajo',
            'operarios',
            'cita',
            'archivos',
            'presupuesto',
            'partesTrabajo',
            'proyecto',
            'archivos.comentarios',
            'cliente.tipoCliente',
        )->get();

        // partes de trabajo
        $partes = PartesTrabajo::
        with(
            'cliente',
            'trabajo',
            'orden.operarios',
            'orden.operarios.user',
            'archivos',
            'orden',
            'proyectoNMN.proyecto',
            'archivos.archivo',
            'cliente.tipoCliente',
        )
        ->orderBy('idParteTrabajo', 'desc')->get();
        $citas  = Cita::all();
        $articulos = Articulos::all();

        // obtener los usuarios que tengan el rol de tecnico
        $users = User::whereHas('roles', function($query){
            $query->where('name', 'tecnico')->orWhere('name', 'admin');
        })->get();

        $bancos = Banco::all();

        $isAdmin = Auth::user()->id;
        $isAdmin = User::find($isAdmin)->isAdmin();

        return view('home', compact(
            'ventas',
            'projects',
            'clientes',
            'trabajos',
            'empresas',
            'proveedores',
            'ordenes',
            'operarios',
            'partes',
            'citas',
            'articulos',
            'compras',
            'isAdmin',
            'users',
            'bancos'
        ));
    }

    public function getInfo( $type )
    {
        try {
            
            switch ($type) {
                case 'compras':

                    $result = Compra::JOIN('lineascompras_sl', 'compras_sl.idCompra', 'lineascompras_sl.idLinea')
                        ->JOIN('proveedores', 'lineascompras_sl.proveedor_id', 'proveedores.idProveedor')
                        ->OrderBy('compras_sl.fechaCompra', 'DESC')
                        ->Select(
                            'compras_sl.*', 
                            'proveedores.nombreProveedor', 
                            'lineascompras_sl.descripcion', 
                            'lineascompras_sl.cantidad', 
                            'lineascompras_sl.precioSinIva', 
                            'lineascompras_sl.descuento', 
                            'lineascompras_sl.total', 
                            'lineascompras_sl.trazabilidad'
                        )
                        ->get();
                    
                    foreach ($result as $re) {
                        $comprasArchivos = DB::table('compras_sl_has_archivos')->Where('compra_id', $re->idCompra)->get();
                        $re["lineas"] = lineasCompras::Where('compra_id', $re->idCompra)->get()->toArray();
                        $re["archivo"] = Archivos::Where('idarchivos', $comprasArchivos[0]->archivo_id)->get()->toArray();
                    }

                    break;
                case 'ventas':
                    
                    $result = Ventas::JOIN('ventas_lineas_sl', 'ventas_sl.idVenta', 'ventas_lineas_sl.venta_id')
                        ->JOIN('clientes', 'ventas_sl.cliente_id', 'clientes.idClientes')
                        ->JOIN('proyectos_partes_sl', 'ventas_lineas_sl.parte_trabajo', 'proyectos_partes_sl.parteTrabajo_id')
                        ->JOIN('proyectos_sl', 'proyectos_partes_sl.proyecto_id', 'proyectos_sl.idProyecto')
                        ->OrderBy('ventas_sl.FechaVenta', 'DESC')
                        ->Select(
                            'ventas_sl.*', 
                            'clientes.NombreCliente', 
                            'clientes.ApellidoCliente', 
                            'proyectos_sl.name as proyecto', 
                            'proyectos_sl.description as descripcionProyecto',
                            'ventas_lineas_sl.Descripcion',
                        )
                        ->get();

                    break;
                case 'cobros':
                    
                    $result = PartesTrabajo::Where('estadoVenta', 2)
                        ->get();

                    break;
                case 'citas':
                    
                    $result = PartesTrabajo::Where('estadoVenta', 1)
                        ->JOIN('clientes', 'partestrabajo_sl.cliente_id', 'clientes.idClientes')
                        ->JOIN('trabajos', 'partestrabajo_sl.trabajo_id', 'trabajos.idTrabajo')
                        ->Select('partestrabajo_sl.*', 'clientes.NombreCliente', 'trabajos.nameTrabajo', 'clientes.ApellidoCliente')
                        ->with('cliente', 'trabajo', 'partesTrabajoLineas', 'archivos', 'archivosMany')
                        ->OrderBy('partestrabajo_sl.FechaAlta', 'DESC')
                        ->get();

                    break;
                
                default:
                    $result = Ventas::JOIN('ventas_lineas_sl', 'ventas_sl.idVenta', 'ventas_lineas_sl.venta_id')
                    ->JOIN('clientes', 'ventas_sl.cliente_id', 'clientes.idClientes')
                    ->JOIN('proyectos_partes_sl', 'ventas_lineas_sl.parte_trabajo', 'proyectos_partes_sl.parteTrabajo_id')
                    ->JOIN('proyectos_sl', 'proyectos_partes_sl.proyecto_id', 'proyectos_sl.idProyecto')
                    ->orderBy('ventas_sl.FechaVenta', 'DESC')
                    ->Select(
                        'ventas_sl.*', 
                        'clientes.NombreCliente', 
                        'clientes.ApellidoCliente', 
                        'proyectos_sl.name as proyecto', 
                        'proyectos_sl.description as descripcionProyecto',
                        'ventas_lineas_sl.Descripcion',
                        'ventas_lineas_sl.Trazabilidad',
                    )
                    ->get();
                    break;
            }

            return response()->json($result);


        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

}
