<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\ClientesImport;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\TelefonosClientes;
use App\Models\Banco;
use App\Models\Ciudad;
use App\Models\LineasVentas;
use App\Models\PartesTrabajo;
use App\Models\TipoCliente;
use App\Models\User;
use App\Models\Ventas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use phpseclib3\Crypt\RC2;

class ClientesController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes      = Cliente::with('user', 'ciudad', 'banco', 'tipoCliente', 'telefonos')->get();
        $ciudades      = Ciudad::all();
        $bancos        = Banco::all();
        $tiposClientes = TipoCliente::all();
        $users         = User::all();

        return view('admin.clientes.index', compact(
            'clientes',
            'ciudades',
            'bancos',
            'tiposClientes',
            'users'
        ));
    }

    public function showApi($id, Request $request){
        try {

            $table = $request->name;

            // buscar el cliente segun la tabla, se está recibiendo el id de la tabla
            $model = "App\Models\\$table";

            $model = new $model;

            $data = $model->find($id);

            if ($data) {
                
                $cliente = $data->cliente_id;

                if ($table == 'Cliente') {
                    $cliente = $id;
                }

                // buscar todas las ventas del cliente
                $cliente = Cliente::with('telefonos')->find($cliente);

                return response()->json([
                    'success' => true,
                    'cliente' => $cliente
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el cliente'
                ]);

            }

        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el cliente, '. $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'nombre'         => 'required',
            ]);

            $cliente = Cliente::create([
                'CIF'               => $request->cif,
                'NombreCliente'     => $request->nombre,
                'ApellidoCliente'   => $request->apellido,
                'Direccion'         => $request->direccion ?? 'Sin direccion',
                'CodPostalCliente'  => $request->codPostal ?? '00000',
                'ciudad_id'         => $request->cidades_id ?? 1,
                'EmailCliente'      => $request->email,
                'Agente'            => $request->agente,
                'TipoClienteId'     => $request->tipoClienteId ?? 1,
                'banco_id'          => $request->banco_id ?? 6,
                'SctaContable'      => $request->sctaContable,
                'Observaciones'     => $request->observaciones ?? 'Fichado por ' . Auth::user()->name,
                'user_id'           => null
            ]);

            $telefonos = $request->telefono;
            foreach ($telefonos as $telefono) {
                if ($telefono == null) {
                    continue;
                }
                TelefonosClientes::create([
                    'Clientes_idClientes' => $cliente->idClientes,
                    'telefono' => $telefono
                ]);
            }

            DB::commit();
            return redirect()->route('admin.clientes.index')->with('success', 'Cliente creado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.clientes.index')->with('error', 'Error al crear el cliente');
        }
    }

    public function storeApi(Request $request)
    {
        try {
            DB::beginTransaction();
   
            $cliente = Cliente::create([
                'CIF'               => $request->cif,
                'NombreCliente'     => $request->nombre,
                'ApellidoCliente'   => $request->apellido,
                'Direccion'         => $request->direccion,
                'CodPostalCliente'  => $request->codPostal,
                'ciudad_id'         => $request->cidades_id ?? 1,
                'EmailCliente'      => $request->email,
                'Agente'            => $request->agente,
                'TipoClienteId'     => $request->tipoClienteId ?? 1,
                'banco_id'          => $request->banco_id ?? 6,
                'SctaContable'      => $request->sctaContable,
                'Observaciones'     => $request->observaciones,
                'user_id'           => null
            ]);

 
            $telefonos = $request->telefono;
            foreach ($telefonos as $telefono) {
                if ($telefono == null) {
                    continue;
                }
                TelefonosClientes::create([
                    'Clientes_idClientes' => $cliente->idClientes,
                    'telefono' => $telefono
                ]);
            }
            
            DB::commit();
            return response()->json([
                'success' => true,
                'id' => $cliente->idClientes,
                'nombre' => $cliente->NombreCliente,
                'apellido' => $cliente->ApellidoCliente,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el cliente'
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $cliente = Cliente::find($id);
            $cliente->CIF            = $request->cif;
            $cliente->NombreCliente  = $request->nombre;
            $cliente->ApellidoCliente= $request->apellido;
            $cliente->Direccion      = $request->direccion;
            $cliente->CodPostalCliente= $request->codPostal;
            $cliente->ciudad_id      = $request->cidades_id;
            $cliente->EmailCliente   = $request->email;
            $cliente->Agente         = $request->agente;
            $cliente->TipoClienteId  = $request->tipoClienteId;
            $cliente->banco_id       = $request->banco_id;
            $cliente->SctaContable   = $request->sctaContable;
            $cliente->Observaciones  = ($request->observaciones) ? $request->observaciones : $cliente->Observaciones;
            $cliente->user_id        = ($request->user_id) ? $request->user_id : null;
            $cliente->save();

            // verificar si hay telefonos nuevos
            $telefonos = $request->telefono;

            if( isset($telefonos) && $telefonos || isset($telefonos) && count($telefonos) > 0) {

                $telefonosRegistrados   = TelefonosClientes::where('Clientes_idClientes', $cliente->idClientes)->get();
                $telefonos              = $request->telefono; //telefonos enviados por el formulario

                foreach ($telefonosRegistrados as $telefonoRegistrado) {
                    $telefonoRegistrado->delete();
                }

                foreach ($telefonos as $telefono) {
                    TelefonosClientes::create([
                        'Clientes_idClientes' => $cliente->idClientes,
                        'telefono' => $telefono
                    ]);
                }

            }
            
            DB::commit();
            return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.clientes.index')->with('error', 'Error al actualizar el cliente');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        try {
            Excel::import(new ClientesImport, $request->file('file'));

            return redirect()->route('admin.clientes.index')->with('success', 'Clientes importados correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Error al importar clientes: ' . $e->getMessage());
        }
    }

    public function verifyCif(Request $request)
    {
        $cliente = Cliente::where('CIF', $request->cif)->first();
        if ($cliente) {
            return response()->json([
                'success' => true,
                'cliente' => $cliente,
                'existente' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado',
                'existente' => false
            ]);
        }
    }

    public function getClientes(Request $request)
    {
        $clientes = Cliente::all();
        return response()->json([
            'success' => true,
            'clientes' => $clientes
        ]);
    }

    public function historialCliente(Request $request, $id)
    {
        try {
            $table = $request->table;
            $soloFacturas = $request->soloVentasQuery;
            $trimestre = $request->porTrimQuery;
            $ventaEspecifica = $request->ventasEspecificaParte;

            // Obtener el modelo dinámicamente
            $modelClass = "App\Models\\$table";
            $model = new $modelClass;

            $data = $model->find($id);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el cliente'
                ]);
            }

            // Identificar el cliente
            $clienteId = $table === 'Cliente' ? $id : $data->cliente_id;

            // Construcción base de la consulta de ventas
            $query = Ventas::with('cliente', 'empresa', 'plazo', 'ventaLineas', 'ventaConfirm')
                ->where('cliente_id', $clienteId);

            if (!empty($ventaEspecifica)) {
                // buscar el parte de trabajo y obtener la venta
                $parte = PartesTrabajo::find($ventaEspecifica);

                if (!$parte) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se encontró el parte de trabajo'
                    ]);
                }
                
                $parteEnLinea = LineasVentas::where('parte_trabajo', $parte->idParteTrabajo)->orderBy('idLineaVenta', 'desc')->first();

                if (!$parteEnLinea) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se encontró la venta asociada al parte de trabajo'
                    ]);
                }

                $query->where('idVenta', $parteEnLinea->venta_id);
            }


            // Filtrar por trimestre si aplica
            if (!empty($trimestre)) {
                $query->whereRaw('QUARTER(FechaVenta) = ?', [(int) $trimestre]);
            }

            // Obtener historial y sumatorias según "soloFacturas"
            if (!empty($soloFacturas)) {
                $query->whereHas('ventaConfirm');
            }

            $historial = $query->get();

            // Calcular sumatorias de ventas
            $sumatorias = Ventas::where('cliente_id', $clienteId)
                ->when(!empty($trimestre), function ($q) use ($trimestre) {
                    return $q->whereRaw('QUARTER(FechaVenta) = ?', [(int) $trimestre]);
                })
                ->when(!empty($soloFacturas), function ($q) {
                    return $q->whereHas('ventaConfirm');
                })
                ->when(!empty($ventaEspecifica), function ($q) use ($ventaEspecifica) {
                    return $q->whereHas('ventaLineas', function ($q) use ($ventaEspecifica) {
                        $q->where('parte_trabajo', $ventaEspecifica);
                    });
                })
                ->selectRaw('
                    SUM(TotalFacturaVenta) as totalFactura,
                    SUM(TotalIvaVenta) as totalIva,
                    SUM(TotalRetencionesVenta) as totalRetenciones,
                    SUM(SuplidosVenta) as totalSuplidos,
                    SUM(ImporteVenta) as totalImporte,
                    SUM(PendienteVenta) as totalPendiente
                ')
                ->first();

            // Obtener detalles del cliente
            $cliente = Cliente::find($clienteId);

            return response()->json([
                'success' => true,
                'historial' => $historial,
                'sumatoria' => $sumatorias->totalFactura ?? 0,
                'sumatoriaIva' => $sumatorias->totalIva ?? 0,
                'sumatoriaRetenciones' => $sumatorias->totalRetenciones ?? 0,
                'sumatoriaSuplidos' => $sumatorias->totalSuplidos ?? 0,
                'sumatoriaImporte' => $sumatorias->totalImporte ?? 0,
                'sumatoriaPendiente' => $sumatorias->totalPendiente ?? 0,
                'cliente' => $cliente,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el historial del cliente. ' . $th->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
