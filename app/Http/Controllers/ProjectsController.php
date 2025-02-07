<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articulos;
use App\Models\Banco;
use App\Models\Cliente;
use App\Models\Operarios;
use App\Models\OrdenesTrabajo;
use App\Models\Project;
use App\Models\ProyectosPartes;
use App\Models\Trabajos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('usuario')->get();
        $operarios = Operarios::all();
        $bancos    = Banco::all();
        $clientes  = Cliente::all();
        $trabajos  = Trabajos::all();
        $articulos = Articulos::all();
        return view('admin.projects.index', compact('projects', 'operarios', 'bancos', 'clientes', 'trabajos', 'articulos'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'projectName'           => 'required|string',
                'projectDescription'    => 'required|string',
                'projectStartDate'      => 'required|date',
                'projectEndDate'        => 'required|date',
                'projectStatus'         => 'required|boolean'
            ]);

            $project = Project::create([
                'name'          => $request->projectName,
                'description'   => $request->projectDescription,
                'start_date'    => $request->projectStartDate,
                'end_date'      => $request->projectEndDate,
                'status'        => $request->projectStatus,
                'user_id'       => Auth::id()
            ]);

            return redirect()->back()->with('success', 'Proyecto creado correctamente');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error al crear el proyecto');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'projectName'           => 'required|string',
                'projectDescription'    => 'required|string',
                'projectStartDate'      => 'required|date',
                'projectEndDate'        => 'required|date',
                'projectStatus'         => 'required|boolean'
            ]);

            $project = Project::find($id);
            $project->name          = $request->projectName;
            $project->description   = $request->projectDescription;
            $project->start_date    = $request->projectStartDate;
            $project->end_date      = $request->projectEndDate;
            $project->status        = $request->projectStatus;
            $project->user_id       = Auth::id();
            $project->save();

            return redirect()->back()->with('successEdit', 'Proyecto actualizado correctamente');

        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el proyecto');
        }
    }

    public function getParts($id, Request $request)
    {
        try {
            
            $project = Project::find($id);
            $parts = ProyectosPartes::where('proyecto_id', $project->idProyecto)
                ->whereHas('parteTrabajo', function($query) {
                    $query->where('estadoVenta', 1);
                })
                ->with(['parteTrabajo', 'parteTrabajo.partesTrabajoLineas', 'parteTrabajo.partesTrabajoLineas.articulo', 'parteTrabajo.partesTrabajoLineas.articulo.empresa'])
                ->get();
            
            return response()->json([
                'status' => 'success',
                'partes' => $parts
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getOrdenes(Request $request, $id){
        try {
            
            // Buscar las ordenes de trabajo disponibles que no esten asignadas a un proyecto
            $ordenes = OrdenesTrabajo::whereDoesntHave('proyecto')
            ->with('partesTrabajo')->get();

            // buscar las ordenes de trabajo que esten asignadas a este proyecto
            $ordenesProyecto = OrdenesTrabajo::whereHas('proyecto', function($query) use ($id){
                $query->where('proyecto_id', $id);
            })->with('partesTrabajo')->get();

            return response()->json([
                'status'                => 'success',
                'ordenesDisponibles'    => $ordenes,
                'ordenesProyecto'       => $ordenesProyecto
            ]);
        
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function addOrders(Request $request){
        try {
            $id     = $request->projectId;
            $orden  = $request->orderId;

            $project = Project::find($id);
            $project->ordenes()->attach($orden);

            // verificar si la orden de trabajo tiene una parte de trabajo asignada
            $orden = OrdenesTrabajo::find($orden);

            if($orden->partesTrabajo){
                $project->partes()->attach($orden->partesTrabajo[0]->idParteTrabajo);
            }

            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => 'Ordenes de trabajo agregadas correctamente',
                'order' => $orden
            ]);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function removeOrder(Request $request){
        try {
            $id     = $request->projectId;
            $orden  = $request->orderId;

            $project = Project::find($id);
            $project->ordenes()->detach($orden);

            // verificar si la orden de trabajo tiene una parte de trabajo asignada
            $orden = OrdenesTrabajo::find($orden);

            if($orden->partesTrabajo){
                $project->partes()->detach($orden->partesTrabajo[0]->idParteTrabajo);
            }

            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => 'Ordenes de trabajo removidas correctamente',
                'order' => $orden
            ]);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getAllApi(Request $request){
        try {
            
            $projects = Project::with('usuario', 'ordenes', 'partes', 'partes.partesTrabajoLineas')
            ->orderBy('idProyecto', 'desc')
            ->get();

            return response()->json([
                'status' => 'success',
                'projects' => $projects
            ]);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
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
