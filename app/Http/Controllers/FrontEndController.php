<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function politicas()
    {
        return view('politicas');
    }
}
