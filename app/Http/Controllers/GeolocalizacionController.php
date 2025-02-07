<?php

namespace App\Http\Controllers;

use App\Models\Operarios;
use App\Models\PositionOrder;
use App\Models\Trabajos;
use Illuminate\Http\Request;

class GeolocalizacionController extends Controller
{
    public function index(){

        $geolocalizaciones = PositionOrder::JOIN('ordentrabajo', 'orden_position_sl.orden_id', 'ordentrabajo.idOrdenTrabajo')->get();

        $partesGeo = PositionOrder::JOIN('partestrabajo_sl', 'partestrabajo_sl.idParteTrabajo', 'orden_position_sl.parte_id')->get();

        $trabajos = Trabajos::all();
        $operarios = Operarios::all();
        
        return view('admin.geolocalizacion.index', compact('geolocalizaciones', 'partesGeo', 'trabajos', 'operarios'));
    }
}
