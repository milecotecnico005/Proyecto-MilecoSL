<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesplazamientosController extends Controller
{
    public function index(){
        return view('admin.desplazamientos.index');
    }
}
