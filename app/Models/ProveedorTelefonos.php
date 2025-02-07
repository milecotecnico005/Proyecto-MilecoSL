<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorTelefonos extends Model
{
    use HasFactory;

    protected $table = 'telefonosproveedores';

    protected $primaryKey = 'idtelefonosProveedores';

    protected $fillable = [
        'proveedor_id',
        'telefono',
    ];

    public $timestamps = false;

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

}
