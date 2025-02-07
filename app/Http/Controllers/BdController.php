<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mysqli;

class BdController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function clean(){
        $mysqli = new mysqli("193.203.168.56", "u657674604_mileco_sl_vf", "@Sebas1124", "u657674604_mileco_sl_vf");

        if ($mysqli->connect_error) {
            die("Conexión fallida: " . $mysqli->connect_error);
        }

        $mysqli->query("SET FOREIGN_KEY_CHECKS = 0");

        $result = $mysqli->query("SHOW TABLES");
        while ($row = $result->fetch_array()) {
            $mysqli->query("DROP TABLE IF EXISTS " . $row[0]);
        }

        $mysqli->query("SET FOREIGN_KEY_CHECKS = 1");

        $mysqli->close();

    }

}
