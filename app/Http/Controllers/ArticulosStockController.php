<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articulos;
use Illuminate\Http\Request;

class ArticulosStockController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        $articulos = Articulos::with('categoria', 'stock')->get();
        return view('admin.stock.index', compact('articulos'));
    }
}
