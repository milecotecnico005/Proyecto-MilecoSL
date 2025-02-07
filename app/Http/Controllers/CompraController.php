<?php

namespace App\Http\Controllers;

use App\Models\Archivos;
use App\Models\ArchivosCompras;
use App\Models\Articulos;
use App\Models\ArticulosStock;
use App\Models\Banco;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Empresa;
use App\Models\lineasCompras;
use App\Models\Operarios;
use App\Models\PlazoCompra;
use App\Models\Project;
use App\Models\Proveedor;
use App\Models\Trabajos;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $compras        = Compra::with('proveedor', 'empresa', 'archivos', 'lineas', 'lineas.user')->get();
        $proveedores    = Proveedor::all();
        $empresas       = Empresa::all();
        $ciudades       = Ciudad::all();
        $bancos         = Banco::all();
        $articulos      = Articulos::all();
        $projects       = Project::all();
        $clientes       = Cliente::all();
        $trabajos       = Trabajos::all();
        $operarios      = Operarios::all();
        return view('admin.compras.index', compact('compras', 'proveedores', 'empresas', 'ciudades', 'bancos', 'articulos', 'projects', 'clientes', 'trabajos', 'operarios'));
    }

    public function create()
    {
        return view('compras.create');
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'fechaCompra'           => 'required',
                'empresa_id'            => 'required',
                'NFacturaCompra'        => 'required',
                'proveedor_id'          => 'required',
                'formaPago'             => 'required',
                'Importe'               => 'required|numeric',
                'Iva'                   => 'required|numeric',
                'totalIva'              => 'required|numeric',
                'totalFactura'          => 'required|numeric',
                'file'                  => 'required|file|mimes:pdf,jpg,png',
                'Plazos'                => 'required|integer|min:0',
            ]);

            DB::beginTransaction();

            if ( $request->Plazos == 0 ) {
                $request["frecuenciaPago"] = null;
            }
    
            $compra = Compra::create([
                'fechaCompra'           => Carbon::parse($request->fechaCompra)->format('Y-m-d H:i:s'),
                'empresa_id'            => $request->empresa_id,
                'NFacturaCompra'        => $request->NFacturaCompra,
                'proveedor_id'          => $request->proveedor_id,
                'formaPago'             => $request->formaPago,
                'Importe'               => $request->Importe,
                'Iva'                   => $request->Iva,
                'totalIva'              => $request->totalIva,
                'totalFactura'          => $request->totalFactura,
                'suplidosCompras'       => $request->suplidosCompras,
                'NAsientoContable'      => $request->NAsientoContable,
                'ObservacionesCompras'  => $request->ObservacionesCompras,
                'Plazos'                => $request->Plazos,
                'totalExacto'           => $request->totalFacturaExacto,
            ]);
    
            // Lógica para manejo de archivo
            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $folder = $compra->idCompra;
    
                $path = public_path("/archivos/compras/$folder");

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $name = str_replace(' ', '_', $file->getClientOriginalName());
                $file->move($path, $name);

                $path = "archivos/compras/$folder";

                $archivo = Archivos::create([
                    'nameFile' => $name,
                    'typeFile' => $file->getClientOriginalExtension(),
                    'pathFile' => $path . "/" . $name,
                ]);


                $images[] = public_path($path . "/" . $name);
                    
                ArchivosCompras::create([
                    'compra_id' => $compra->idCompra,
                    'archivo_id' => $archivo->idarchivos,
                ]);
            }

            // Lógica para manejo de plazos
            if ($compra->Plazos == 0) {
                // Todo como pagado
                PlazoCompra::create([
                    'fecha_pago' => $compra->fechaCompra,
                    'estadoPago' => 2,
                    'compra_id' => $compra->idCompra,
                    'userAction' => Auth::user()->id,
                ]);
            } else {
                // Manejo de plazos según el valor de Plazos
                $this->handlePlazos($compra, $request);
            }

            DB::commit();
    
            return response()->json([
                'message'   => 'Compra creada con éxito Por favor ingresa las lineas correspondientes a la compra',
                'compra'    => $compra,
                'proveedor' => $compra->proveedor,
                'empresa'   => $compra->empresa,
                'archivos'  => $compra->archivos,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la compra',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 500);
        }
    }

    public function storeLinea(Request $request){
        try {
            $request->validate([
                'proveedor_id'           => 'required',
                'descripcion'            => 'required',
                'cantidad'               => 'required',
                'precioSinIva'           => 'required',
                'descuento'              => 'required',
                'total'                  => 'required',
                'compra_id'              => 'required'
            ]);

            DB::beginTransaction();

            //TODO: Crear la lógica para manejar la trazabilidad
            $compra = Compra::findOrFail($request->compra_id);
            $archivo = ArchivosCompras::where('compra_id', $compra->idCompra)->first();
            $empresa = Empresa::findOrFail($compra->empresa_id);

            $trazabilidad = '';

            $Linea = lineasCompras::create([
                'proveedor_id'           => $request->proveedor_id,
                'descripcion'            => $request->descripcion,
                'cantidad'               => $request->cantidad,
                'precioSinIva'           => $request->precioSinIva,
                'RAE'                    => $request->rae,
                'descuento'              => $request->descuento,
                'total'                  => $request->total,
                'trazabilidad'           => $request->trazabilidad,
                'compra_id'              => $request->compra_id,
                'cod_proveedor'          => $request->cod_prov,
                'user_create'            => Auth::user()->id,
            ]);

            // Crear el articulo en la tabla de articulos
            $compra = Compra::findOrFail($request->compra_id);

            $ptsCosto = $request->precioSinIva;
            // obtener el 25% de beneficio sobre el costo
            $beneficio = $ptsCosto * 0.25;

            // Sumar el beneficio al costo para obtener el precio de venta
            $ptsVenta = $ptsCosto + $beneficio;
            $empresa_id = $compra->empresa_id;

            $articulo = Articulos::create([
                'categoria_id'          => 1,
                'nombreArticulo'        => $request->descripcion,
                'ptsCosto'              => $request->precioSinIva,
                'ptsVenta'              => $ptsVenta,
                'Beneficio'             => $beneficio,
                'empresa_id'            => $empresa_id,
                'proveedor_id'          => $request->proveedor_id,
                'SubctaInicio'          => 1,
                'TrazabilidadArticulos' => $request->trazabilidad,
                'compra_id'             => $compra->idCompra,
                'Observaciones'         => $request->descripcion,
            ]);

            // obtener la linea creada para agregarle el articulo_id
            $Linea->update([
                'articulo_id' => $articulo->idArticulo,
            ]);

            // Crear stock para el articulo

            $stock = ArticulosStock::create([
                'articulo_id'       => $articulo->idArticulo,
                'ultimaCompraDate'  => Carbon::now(),
                'existenciasMin'    => 0,
                'cantidad'          => $request->cantidad,
                'existenciasMax'    => 0,
            ]);

            DB::commit();

            return response()->json([
                'message'   => 'Linea creada con éxito',
                'linea'     => $Linea,
                'proveedor' => $Linea->proveedor,
                'compra'    => $Linea->compra,
                'archivos'  => $archivo,
            ], 201);

        }catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la compra',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 500);
        }
    }

    private function handlePlazos(Compra $compra, Request $request)
    {
        if ($compra->Plazos == 1) {
            PlazoCompra::create([
                'fecha_pago' => $compra->fechaCompra,
                'estadoPago' => 1,
                'proximoPago' => $request->proximoPago,
                'compra_id' => $compra->idCompra,
                'userAction' => Auth::id(),
            ]);
        } elseif ($compra->Plazos > 1) {
            $frecuencia         = $request->frecuenciaPago;
            $fechaSiguientePago = Carbon::parse($request->fechaSiguientePago);

            // convertir $request->plazos a un número entero
            $compra->Plazos = intval($request->Plazos);
        
            // Calcula las fechas basadas en la frecuencia
            $fechaPago = Carbon::parse($compra->fechaCompra);
            for ($i = 0; $i < $compra->Plazos; $i++) {
                // Define la fecha de próximo pago basada en la frecuencia
                switch ($frecuencia) {
                    case 'mensual':
                        $proximoPago = $fechaPago->copy()->addMonth();
                        break;
                    case 'semanal':
                        $proximoPago = $fechaPago->copy()->addWeek();
                        break;
                    case 'quincenal':
                        $proximoPago = $fechaPago->copy()->addWeeks(2);
                        break;
                    default:
                        throw new Exception('Frecuencia de pago no soportada');
                }

                // Crea el registro del plazo
                PlazoCompra::create([
                    'frecuenciaPago' => $frecuencia,
                    'fecha_pago' => $fechaPago,
                    'estadoPago' => 1,
                    'proximoPago' => $proximoPago,
                    'compra_id' => $compra->idCompra,
                    'userAction' => Auth::user()->id,
                ]);
        
                // Actualiza las fechas para el próximo ciclo
                $fechaPago = $proximoPago;
            }
        }
    }

    public function show($id)
    {
        $compra = Compra::findOrFail($id);

        // buscar el ultimo archivo subido pdf para mostrarlo
        $archivo = ArchivosCompras::where('compra_id', $compra->idCompra)
        ->leftJoin('archivos', 'archivos.idarchivos', '=', 'compras_sl_has_archivos.archivo_id')
        ->latest()->first();

        $lineas = lineasCompras::where('compra_id', $compra->idCompra)
        ->with('proveedor', 'compra', 'articulo', 'user')
        ->get();

        return response()->json([
            'success' => true,
            'compra' => $compra,
            'proveedor' => $compra->proveedor,
            'empresa' => $compra->empresa,
            'archivo' => $archivo,
            'lineas' => $lineas,
        ]);
    }

    public function edit($id)
    {
        $compra = Compra::findOrFail($id);
        return view('compras.edit', compact('compra'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $compra = Compra::findOrFail($id);
        $compra->fechaCompra = Carbon::parse($request->fechaCompra)->format('Y-m-d H:i:s');
        $compra->empresa_id = $request->empresa_id;
        $compra->NFacturaCompra = $request->NFacturaCompra;
        $compra->proveedor_id = $request->proveedor_id;
        $compra->formaPago = $request->formaPago;
        $compra->Importe = $request->Importe;
        $compra->Iva = $request->Iva;
        $compra->totalIva = $request->totalIva;
        $compra->totalFactura = $request->totalFactura;
        $compra->suplidosCompras = $request->suplidosCompras;
        $compra->NAsientoContable = $request->NAsientoContable;
        $compra->ObservacionesCompras = $request->ObservacionesCompras;
        $compra->Plazos = $request->Plazos;
        $compra->totalExacto = $request->totalFacturaExacto;
        $compra->save();

        // Lógica para manejo de archivo y si se ha subido un archivo reemplazarlo por el anterior
        if ($request->hasFile('file')) {

            $archivosCompras = ArchivosCompras::where('compra_id', $compra->idCompra)->first();
            $archivo = Archivos::findOrFail($archivosCompras->archivo_id);

            $file = $request->file('file');
            $folder = $compra->idCompra;

            $path = public_path("/archivos/compras/$folder");
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $name = str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $name);

            $path = "archivos/compras/$folder";

            $archivo = $archivo->update([
                'nameFile' => $name,
                'typeFile' => $file->getClientOriginalExtension(),
                'pathFile' => $path . "/" . $name,
            ]);

            $images[] = public_path($path . "/" . $name);

        
            $archivosCompras->update([
                'compra_id' => $compra->idCompra,
                'archivo_id' => $archivosCompras->archivo_id,
            ]);
        }

        $this->sendTelegramUpdate($compra->idCompra);

        DB::commit();
        return redirect()->route('admin.compras.index')->with('success', 'Compra actualizada con éxito');
    }

    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->delete();
        
        return response()->json([
            'message' => 'Compra eliminada con éxito',
        ], 201);

    }

    public function updatesum(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);
        
        $compra->update([
            'Importe'           => $request->importe,
            'suplidosCompras'   => $request->suplidos,
            'totalIva'          => $request->totalIva,
            'totalFactura'      => $request->totalFactura,
        ]);
        
        return response()->json([
            'message'   => 'Compra actualizada con éxito',
            'compra'    => $compra,
            'proveedor' => $compra->proveedor,
            'empresa'   => $compra->empresa,
            'archivos'  => $compra->archivos,
        ], 201);
    }

    public function updateLinea(Request $request, $id){
        try {

            DB::beginTransaction();
            $linea = lineasCompras::findOrFail($id);
            
            $linea->update([
                'descripcion'   => $request->descripcion,
                'cantidad'      => $request->cantidad,
                'precioSinIva'  => $request->precioSinIva,
                'descuento'     => $request->descuento,
                'total'         => $request->total,
                'RAE'           => $request->rae,
                'cod_proveedor' => $request->cod_prov,
                'user_create'   => Auth::user()->id,
            ]);

            // Actualizar stock del articulo
            $compra = Compra::findOrFail($linea->compra_id);
            $articulo = Articulos::where([
                'compra_id'             => $compra->idCompra,
                'TrazabilidadArticulos' => $linea->trazabilidad,
                'nombreArticulo'        => $linea->descripcion,
            ])->first();

            if ( $articulo ) {
                
                $ptsCosto = $request->precioSinIva;
                // obtener el 25% de beneficio sobre el costo
                $beneficio = $ptsCosto * 0.25;

                // Sumar el beneficio al costo para obtener el precio de venta
                $ptsVenta = $ptsCosto + $beneficio;

                $articulo->update([
                    'ptsCosto'       => $request->precioSinIva,
                    'ptsVenta'       => $ptsVenta,
                    'Beneficio'      => $beneficio,
                    'nombreArticulo' => $request->descripcion,
                ]);

                $stock = ArticulosStock::where('articulo_id', $articulo->idArticulo)->first();
                $stock->update([
                    'cantidad' => $request->cantidad,
                ]);
            }

            $this->sendTelegramUpdate($compra->idCompra);

            DB::commit();
            return response()->json([
                'message'   => 'Linea actualizada con éxito',
                'linea'    => $linea,
                'proveedor' => $linea->proveedor,
                'compra'   => $linea->compra,
            ], 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar la linea',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
        }
    }

    public function destroyLinea($id)
    {
        try {

            DB::beginTransaction();
            $linea = lineasCompras::findOrFail($id);

            // buscar el articulo asociado a la linea
            $compra = Compra::findOrFail($linea->compra_id);

            $articulo = Articulos::where([
                'compra_id'             => $compra->idCompra,
                'TrazabilidadArticulos' => $linea->trazabilidad,
                'nombreArticulo'        => $linea->descripcion,
            ])->first();
            
            if ( $articulo ) {

                $stock = ArticulosStock::where('articulo_id', $articulo->idArticulo)->first();
                $stock->delete();
                $articulo->delete();
            }
            
            $linea->delete();
            DB::commit();

            return response()->json([
                'message' => 'Linea eliminada con éxito',
            ], 201);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar la linea',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
        }
    }

    public function getInfoToStore(Request $request)
    {
        try {

            $proveedor  = Proveedor::findOrFail($request->proveedor_id);
            $empresa    = Empresa::findOrFail($request->empresa_id);
            $compra     = Compra::findOrFail($request->idCompra);
            $archivo    = ArchivosCompras::where('compra_id', $compra->idCompra)->first();

            return response()->json([
                'proveedor' => $proveedor,
                'empresa'   => $empresa,
                'compra'    => $compra,
                'archivo'   => $archivo,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al obtener la información',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ], 500);
        }
    }

    public function sendTelegram(Request $request){
        try{

            $compra     = Compra::findOrFail($request->id);
            $proveedor  = Proveedor::findOrFail($compra->proveedor_id);
            $empresa    = Empresa::findOrFail($compra->empresa_id);
            $archivos   = ArchivosCompras::where('compra_id', $compra->idCompra)
            ->leftJoin('archivos', 'archivos.idarchivos', '=', 'compras_sl_has_archivos.archivo_id')
            ->latest()
            ->first();

            $archivo    = Archivos::findOrFail($archivos->archivo_id);
            $user       = Auth::user()->name;

            // valores formateados
            $compra->Importe = formatPrice($compra->Importe);
            $compra->Iva = $compra->Iva.'%';
            $compra->totalIva = formatPrice($compra->totalIva);
            $compra->totalFactura = formatPrice($compra->totalFactura);
            $compra->suplidosCompras = formatPrice($compra->suplidosCompras);
            $compra->totalExacto = formatPrice($compra->totalExacto);

            $metodo = ($compra->formaPago == '1') ? 'Banco' : 'Efectivo';

            $message = "--- Nueva Factura De Compra ---\n";
            $message = "ID Compra: #$compra->idCompra\n\n";

            $message .= "--- Información de la compra ---\n";
            $message .= "Compra: $compra->NFacturaCompra\n";
            $message .= "Fecha de Compra: $compra->fechaCompra\n";
            $message .= "Proveedor: $proveedor->nombreProveedor\n";
            $message .= "Empresa: $empresa->EMP\n";
            $message .= "M.Pago: $metodo\n\n";

            $message .= "--- Detalles de la compra ---\n";
            $message .= "Importe: $compra->Importe\n";
            $message .= "IVA: $compra->Iva\n";
            $message .= "Total IVA: $compra->totalIva\n";
            $message .= "Suplidos: $compra->suplidosCompras\n";
            $message .= "Total Factura: $compra->totalFactura\n";
            $message .= "Total Exacto: $compra->totalExacto\n";
            $message .= "Nº Asiento Contable: $compra->NAsientoContable\n";
            $message .= "Observaciones: $compra->ObservacionesCompras\n";
            $message .= "Plazos: $compra->Plazos\n\n";

            $message .= "Factura subida por el usuario: $user\n";

            $media = [];

            $mediaType = '';
            $extension = $archivo->typeFile;

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $mediaType = 'photo'; // Imagen
            } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
                $mediaType = 'video'; // Video
            } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                $mediaType = 'audio'; // Audio
            }elseif (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                $mediaType = 'document'; // Word, Excel, PDF
            }

            $media[] = [
                'path' => $archivo->pathFile,
                'type' => $mediaType,
                'comment' => $message,
            ];

            $message = "";

            // Enviar notificación a Telegram
            $telegramController = new NotificationsController();
            $chatIdAutomatico = $telegramController->getCurrentChatIdByConfig('compras');

            $telegramController->sendMessageTelegram($chatIdAutomatico, $message, $media);

            return response()->json([
                'message' => 'Mensaje enviado con éxito',
            ], 200);

        }catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al enviar el mensaje',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ], 500);
        }
    }

    public static function sendTelegramUpdate($id){

        $compra = Compra::findOrFail($id);
        $proveedor = Proveedor::findOrFail($compra->proveedor_id);
        $empresa = Empresa::findOrFail($compra->empresa_id);
        $metodo = ($compra->formaPago == '1') ? 'Banco' : 'Efectivo';

        // valores formateados
        $compra->Importe = formatPrice($compra->Importe);
        $compra->Iva = $compra->Iva.'%';
        $compra->totalIva = formatPrice($compra->totalIva);
        $compra->totalFactura = formatPrice($compra->totalFactura);
        $compra->suplidosCompras = formatPrice($compra->suplidosCompras);
        $compra->totalExacto = formatPrice($compra->totalExacto);

        // enviar notificación a Telegram
        $message = "--- Compra Actualizada ---\n";
        $message .= "ID Compra: #$compra->idCompra\n\n";

        $message .= "--- Información de la compra ---\n";
        $message .= "Compra: $compra->NFacturaCompra\n";
        $message .= "Fecha de Compra: $compra->fechaCompra\n";
        $message .= "Proveedor: $proveedor->nombreProveedor\n";
        $message .= "Empresa: $empresa->EMP\n";
        $message .= "M.Pago: $metodo\n\n";

        $message .= "--- Detalles de la compra ---\n";
        $message .= "Importe: $compra->Importe\n";
        $message .= "IVA: $compra->Iva\n";
        $message .= "Total IVA: $compra->totalIva\n";
        $message .= "Suplidos: $compra->suplidosCompras\n";
        $message .= "Total Factura: $compra->totalFactura\n";
        $message .= "Total Exacto: $compra->totalExacto\n";
        $message .= "Nº Asiento Contable: $compra->NAsientoContable\n";
        $message .= "Observaciones: $compra->ObservacionesCompras\n";
        $message .= "Plazos: $compra->Plazos\n\n";

        $message .= "---- Lineas de la compra: ----\n\n";

        foreach ($compra->lineas as $linea) {

            // formatear los precios
            $linea->precioSinIva = formatPrice($linea->precioSinIva);
            $linea->total = formatPrice($linea->total);
            $responsable = User::find($linea->user_create)->name ?? Auth::user()->name;
            
            $message .= "Descripción: $linea->descripcion\n";
            $message .= "Cantidad: $linea->cantidad\n";
            $message .= "Precio sin IVA: $linea->precioSinIva\n";
            $message .= "Descuento: $linea->descuento\n";
            $message .= "Total: $linea->total\n";
            $message .= "RAE: $linea->RAE\n";
            $message .= "Código Proveedor: $linea->cod_proveedor\n";
            $message .= "Responsable: $responsable\n\n";
        }

        $message .= "Factura actualizada por el usuario: ".Auth::user()->name;
     
        $media = [];
        $archivo = ArchivosCompras::where('compra_id', $compra->idCompra)
            ->leftJoin('archivos', 'archivos.idarchivos', '=', 'compras_sl_has_archivos.archivo_id')
            ->latest()
            ->first();
            

        $mediaType = '';
        $extension = $archivo->typeFile;

        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $mediaType = 'photo'; // Imagen
        } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
            $mediaType = 'video'; // Video
        } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
            $mediaType = 'audio'; // Audio
        }elseif (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
            $mediaType = 'document'; // Word, Excel, PDF
        }

        $media[] = [
            'path' => $archivo->pathFile,
            'type' => $mediaType,
            'comment' => $message,
        ];

        $message = "";

        // Enviar notificación a Telegram
        $telegramController = new NotificationsController();
        $chatIdAutomatico = $telegramController->getCurrentChatIdByConfig('compras');

        $telegramController->sendMessageTelegram($chatIdAutomatico, $message, $media);
    }

    public function getArticuloByCodigo(Request $request)
    {
        try {
            // puede que tenga varias veces el mismo código de proveedor necesitamos obtener el último
            $articulo = lineasCompras::where('cod_proveedor', $request->cod_prov)->ORDERBY('idLinea', 'DESC')->first();

            if ( !$articulo ) {
                return response()->json([
                    'message' => 'Articulo no encontrado',
                    'status' => false,
                ], 404);
            }

            return response()->json([
                'articulo' => $articulo,
                'status' => true,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al obtener el articulo',
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTraceAsString(),
            ], 500);
        }
    }

}
