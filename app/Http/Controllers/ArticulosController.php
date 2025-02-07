<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Archivos;
use App\Models\Articulos;
use App\Models\ArticulosCategorias;
use App\Models\ArticulosImagenes;
use App\Models\ArticulosStock;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Empresa;
use App\Models\lineasCompras;
use App\Models\Operarios;
use App\Models\PartesTrabajo;
use App\Models\PartesTrabajoLineas;
use App\Models\Project;
use App\Models\Proveedor;
use App\Models\Trabajos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticulosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articulos      = Articulos::with('categoria', 'stock', 'imagenes', 'proveedor', 'empresa', 'compras', 'compras.lineas')
        ->LEFTJOIN('traspasos_sl', 'articulos_sl.idArticulo', '=', 'traspasos_sl.articulo_id')
        ->select('articulos_sl.*', 'traspasos_sl.articulo_traspasado', 'traspasos_sl.cantidad as cantidad_traspasada', 'traspasos_sl.fecha_traspaso', 'traspasos_sl.articulo_id')
        ->get();

        $empresas       = Empresa::all();
        $proveedores    = Proveedor::all();
        $categorias     = ArticulosCategorias::all();
        $trazabilidades = lineasCompras::select('trazabilidad', 'compra_id')->distinct()->get();
        $projects       = Project::all();
        $clientes       = Cliente::all();
        $trabajos       = Trabajos::all();
        $operarios      = Operarios::all();

        return view('admin.articulos.index', compact('articulos', 'empresas', 'proveedores', 'categorias', 'trazabilidades', 'projects', 'clientes', 'trabajos', 'operarios'));
    }

    public function edit($id){
        try {
            
            $articulos = Articulos::with('categoria', 'stock', 'imagenes', 'proveedor', 'empresa', 'compras', 'compras.lineas')
            ->LEFTJOIN('traspasos_sl', 'articulos_sl.idArticulo', '=', 'traspasos_sl.articulo_id')
            ->select('articulos_sl.*', 'traspasos_sl.articulo_traspasado', 'traspasos_sl.cantidad as cantidad_traspasada', 'traspasos_sl.fecha_traspaso', 'traspasos_sl.articulo_id')
            ->find($id);

            return response()->json([
                'success' => true,
                'articulo' => $articulos,
                'status' => 200
            ]);

        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los articulos',
                'status' => 500,
                'error' => $error->getMessage()
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el articulo',
                'status' => 500
            ]);
        }
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'nombre' => 'required',
                'categoria_id' => 'required',
                'empresa_id' => 'required',
                'proveedor_id' => 'required',
                'ptsCosto' => 'required',
                'ptsVenta' => 'required',
                'Beneficio' => 'required',
                'SubctaInicio' => 'required',
                'TrazabilidadArticulos' => 'required',
                'ultimaCompraDate' => 'required|date',
                'existenciasMin' => 'required',
                'cantidad' => 'required',
                'existenciasMax' => 'required',
            ]);

            // obtener la traibilidad
            $trazabilidad = lineasCompras::where('compra_id', $request->TrazabilidadArticulos)->first();

            $articulo = Articulos::create([
                'nombreArticulo' => $request->nombre,
                'categoria_id' => $request->categoria_id,
                'empresa_id' => $request->empresa_id,
                'proveedor_id' => $request->proveedor_id,
                'ptsCosto' => $request->ptsCosto,
                'ptsVenta' => $request->ptsVenta,
                'Beneficio' => $request->Beneficio,
                'SubctaInicio' => $request->SubctaInicio,
                'TrazabilidadArticulos' => $trazabilidad->trazabilidad,
                'Observaciones' => $request->observaciones,
            ]);

            // Crear stock
            $stock = ArticulosStock::create([
                'articulo_id' => $articulo->idArticulo,
                'ultimaCompraDate' => $request->ultimaCompraDate,
                'existenciasMin' => $request->existenciasMin,
                'cantidad' => $request->cantidad,
                'existenciasMax' => $request->existenciasMax,
            ]);

            return redirect()->route('admin.articulos.index')->with('success', 'Articulo creado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.articulos.index')->with('error', 'Error al crear el articulo. ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'categoria_id' => 'required',
                'empresa_id' => 'required',
                'proveedor_id' => 'required',
                'ptsCosto' => 'required',
                'ptsVenta' => 'required',
                'Beneficio' => 'required',
                'SubctaInicio' => 'required',
                'TrazabilidadArticulos' => 'required',
                'ultimaCompraDate' => 'required|date',
                'existenciasMin' => 'required',
                'cantidad' => 'required',
                'existenciasMax' => 'required',
            ]);

            DB::beginTransaction();
            $articulo = Articulos::find($id);

            // verificar si subieron Imagenges
            if ( isset($request->images) && count($request->images) > 0 ) {
                $folder = formatFolderName($id);
                $path = public_path("/archivos/articulos/$folder");
                $files = $request->file('images');
                
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                
                foreach ($files as $key => $file) {
                    $name = str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move($path, $name);

                    $comentario = $request->comentario[$key] ?? '';

                    $path = "archivos/articulos/$folder";

                    $archivo = Archivos::create([
                        'nameFile' => $name,
                        'typeFile' => $file->getClientOriginalExtension(),
                        'pathFile' => $path . "/" . $name,
                    ]);

                    ArticulosImagenes::create([
                        'archivo_id' => $archivo->idarchivos,
                        'articulo_id'=> $id,
                        'comentarioArchivo' => $comentario
                    ]);

                    // buscar por cod_proveedor de lineasCompras todos los articulos con el mismo cod_proveedor y añadirle la imagen
                    $articuloEnLineas = lineasCompras::where('articulo_id', $id)->first();

                    $articulosConMismoCodProveedor = lineasCompras::where('cod_proveedor', $articuloEnLineas->cod_proveedor)->get();

                    // añadir la imagen a los articulos con el mismo cod_proveedor
                    foreach ($articulosConMismoCodProveedor as $articuloConMismoCodProveedor) {

                        // a excepcion del articulo que se esta actualizando
                        if ( $articuloConMismoCodProveedor->articulo_id == $id ) {
                            continue;
                        }

                        ArticulosImagenes::create([
                            'archivo_id' => $archivo->idarchivos,
                            'articulo_id'=> $articuloConMismoCodProveedor->articulo_id,
                            'comentarioArchivo' => $comentario
                        ]);
                    }

                }
            }

            // obtener la traibilidad
            $trazabilidad = lineasCompras::where('compra_id', $request->TrazabilidadArticulos)->first();

            
            $articulo->nombreArticulo = $request->nombre;
            $articulo->categoria_id = $request->categoria_id;
            $articulo->empresa_id = $request->empresa_id;
            $articulo->proveedor_id = $request->proveedor_id;
            $articulo->ptsCosto = $request->ptsCosto;
            $articulo->ptsVenta = $request->ptsVenta;
            $articulo->Beneficio = $request->Beneficio;
            $articulo->SubctaInicio = $request->SubctaInicio;
            $articulo->TrazabilidadArticulos = $trazabilidad->trazabilidad;
            $articulo->Observaciones = $request->observaciones;
            $articulo->save();

            // Crear stock
            $stock = ArticulosStock::where('articulo_id', $id)->first();
            $stock->ultimaCompraDate = $request->ultimaCompraDate;
            $stock->existenciasMin = $request->existenciasMin;
            $stock->cantidad = $request->cantidad;
            $stock->existenciasMax = $request->existenciasMax;
            $stock->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Articulo actualizado correctamente',
                'status' => 200
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el articulo. ' . $e->getMessage(),
                'status' => 500
            ]);
        }
    }

    public function getStock(string $id)
    {
        $stock = ArticulosStock::where('articulo_id', $id)
        ->where('articulos_stock_sl.cantidad', '>', 0)
        ->with('articulo', 'articulo.imagenes')
        ->first();
        
        if ( !$stock ) {
            return response()->json([
                'success' => false,
                'message' => 'No tiene stock disponible',
                'status' => 404
            ]);
        }
        
        if ( $stock->cantidad <= 0 ) {
            return response()->json([
                'success' => false,
                'message' => 'No hay stock disponible',
                'status' => 404
            ]);
        }

        return response()->json([
            'success' => true,
            'stock' => $stock,
            'status' => 200
        ]);
    }

    public function historial( $id ){
        try {
            
            $lineasPartes = PartesTrabajoLineas::where('articulo_id', $id)
            ->with(
                'parteTrabajo', 
                'parteTrabajo.cliente', 
                'parteTrabajo.trabajo', 
                'parteTrabajo.archivos',
                'parteTrabajo.archivosMany', 
                'parteTrabajo.orden', 
                'parteTrabajo.orden.archivos',
                'parteTrabajo.orden.operarios', 
                'parteTrabajo.orden.proyecto',
                'articulo'
            )
            ->get();

            $articulo = Articulos::with(
                'categoria',
                'stock',
                'empresa',
                'proveedor',
                'compras',
                'compras.archivos',
                'compras.lineas',
            )->find($id);

            // verificar si el articulo tiene imagenes
            $images = ArticulosImagenes::with('archivo')->where('articulo_id', $id)->get();

            if ( $images ) {
                $articulo["imgArticulo"] = $images;
            }
            
            return response()->json([
                'success'   => true,
                'data'      => $lineasPartes,
                'articulo'  => $articulo,
                'status'    => 200
            ]);

        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el historial del articulo',
                'status' => 500,
                'error' => $error->getMessage()
            ]);
        }
    }

    public function getImages( $id ){
        try {
            $images = ArticulosImagenes::where('articulo_id', $id)
            ->with('archivo')
            ->get();

            if ( !$images ) {
                throw new \Exception('No se encontraron imagenes');
            }

            return response()->json([
                'success'   => true,
                'data'      => $images,
                'status'    => 200
            ]);

        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las imagenes del articulo',
                'status' => 500,
                'error' => $error->getMessage()
            ]);
        }
    }

    public function deleteImage( $id ){
        try {
            $image = Archivos::find($id);
            $archivo = ArticulosImagenes::where('archivo_id', $id)->first();
            $archivo->delete();
            $image->delete();

            return response()->json([
                'success'   => true,
                'message'   => 'Imagen eliminada correctamente',
                'status'    => 200
            ]);

        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la imagen',
                'status' => 500,
                'error' => $error->getMessage()
            ]);
        }
    }

}
