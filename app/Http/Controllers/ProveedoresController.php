<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banco;
use App\Models\Ciudad;
use App\Models\Proveedor;
use App\Models\ProveedorTelefonos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProveedoresController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bancos = Banco::all();
        $ciudades = Ciudad::all();
        $proveedores = Proveedor::with('ciudad', 'banco')->get();
        return view('admin.proveedores.index', compact('bancos', 'ciudades', 'proveedores'));
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            // Validar la solicitud
            $request->validate([
                'cifProveedor'          => 'required',
                'nombreProveedor'       => 'required',
            ]);

            // Crear el proveedor
            $proveedor = Proveedor::create([
                'cifProveedor'          => $request->input('cifProveedor'),
                'nombreProveedor'       => $request->input('nombreProveedor'),
                'direccionProveedor'    => $request->input('direccionProveedor'),
                'codigoPostalProveedor' => $request->input('codigoPostalProveedor'),
                'ciudad_id'             => $request->input('ciudad_id') ?? 1,
                'emailProveedor'        => $request->input('emailProveedor'),
                'agenteProveedor'       => $request->input('agenteProveedor'),
                'tipoProveedor'         => $request->input('tipoProveedor'),
                'banco_id'              => $request->input('banco_id') ?? 6,
                'Scta_ConInicio'        => $request->input('Scta_ConInicio'),
                'Scta_Contable'         => $request->input('Scta_Contable'),
                'observacionesProveedor' => $request->input('observacionesProveedor') ?? 'Ninguna',
            ]);

            // agregar telefonos

            if ( $request->has('telefono') && count($request->telefono) > 0 ) {
                foreach ($request->telefono as $telefono) {
                    ProveedorTelefonos::create([
                        'proveedor_id' => $proveedor->idProveedor,
                        'telefono' => $telefono
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor creado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.proveedores.index')->with('error', 'Ocurrió un error al crear el proveedor, '.$e->getMessage());
        }
    }

    public function storeApi(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'cifProveedor'          => 'required',
                'nombreProveedor'       => 'required',
            ]);

            // Crear el proveedor
            $proveedor = Proveedor::create([
                'cifProveedor'          => $request->cifProveedor,
                'nombreProveedor'       => $request->nombreProveedor,
                'direccionProveedor'    => $request->direccionProveedor,
                'codigoPostalProveedor' => $request->codigoPostalProveedor,
                'ciudad_id'             => $request->ciudad_id ?? 1,
                'emailProveedor'        => $request->emailProveedor,
                'agenteProveedor'       => $request->agenteProveedor,
                'tipoProveedor'         => $request->tipoProveedor ?? 2,
                'banco_id'              => $request->banco_id ?? 6,
                'Scta_ConInicio'        => $request->Scta_ConInicio,
                'Scta_Contable'         => $request->Scta_Contable,
                'observacionesProveedor' => $request->observacionesProveedor ?? 'Ninguna',
            ]);

            // agregar telefonos

            if ( $request->has('telefono') && count($request->telefono) > 0 ) {
                foreach ($request->telefono as $telefono) {
                    ProveedorTelefonos::create([
                        'proveedor_id' => $proveedor->idProveedor,
                        'telefono' => $telefono
                    ]);
                }
            }
        
            return response()->json([
                'status' => 'success',
                'message' => 'Proveedor creado correctamente',
                'id' => $proveedor->idProveedor,
                'nombreProveedor' => $proveedor->nombreProveedor,
            ]);

        } catch (\Exception $e) {
            throw new \Exception('Ocurrió un error al crear el proveedor, '.$e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'cifProveedor'          => 'required',
                'nombreProveedor'       => 'required',
            ]);

            // Buscar el proveedor
            $proveedor = Proveedor::find($id);

            // Actualizar el proveedor
            $proveedor->update([
                'cifProveedor'           => $request->input('cifProveedor'),
                'nombreProveedor'        => $request->input('nombreProveedor'),
                'direccionProveedor'     => $request->input('direccionProveedor'),
                'codigoPostalProveedor'  => $request->input('codigoPostalProveedor'),
                'ciudad_id'              => $request->input('ciudad_id'),
                'emailProveedor'         => $request->input('emailProveedor'),
                'agenteProveedor'        => $request->input('agenteProveedor'),
                'tipoProveedor'          => $request->input('tipoProveedor'),
                'banco_id'               => $request->input('banco_id'),
                'Scta_ConInicio'         => $request->input('Scta_ConInicio'),
                'Scta_Contable'          => $request->input('Scta_Contable'),
                'observacionesProveedor' => $request->input('observacionesProveedor') ?? 'Ninguna',
            ]);

            // Actualizar telefonos
            if ( $request->has('telefono') && count($request->telefono) > 0 ) {
                ProveedorTelefonos::where('proveedor_id', $proveedor->idProveedor)->delete();
                foreach ($request->telefono as $telefono) {
                    ProveedorTelefonos::create([
                        'proveedor_id' => $proveedor->idProveedor,
                        'telefono' => $telefono
                    ]);
                }
            }


            return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.proveedores.index')->with('error', 'Ocurrió un error al actualizar el proveedor, '.$e->getMessage());
        }
    }

    public function show($id){
        try {
            $proveedor = Proveedor::with('ciudad', 'banco', 'telefonos')->find($id);

            if (!$proveedor) {
                return response()->json([
                    'status' => false,
                    'message' => 'Proveedor no encontrado'
                ]);
            }

            return response()->json([
                'success' => true,
                'proveedor' => $proveedor
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error al obtener el proveedor, '.$th->getMessage()
            ]);
        }
    }

    public function getProveedores(){
        $proveedores = Proveedor::all();
        return response()->json([
            'success' => true,
            'proveedores' => $proveedores
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
