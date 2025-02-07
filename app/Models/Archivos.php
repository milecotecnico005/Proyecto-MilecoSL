<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivos extends Model
{
    use HasFactory;

    protected $table = 'archivos';

    protected $primaryKey = 'idarchivos';

    protected $fillable = [
        'nameFile',
        'typeFile',
        'pathFile',
        'empresa_id',
        'created_at',
        'updated_at',
    ];

    public function ordenes()
    {
        return $this->belongsToMany(OrdenesTrabajo::class, 'trabajos_archivos', 'archivo_id', 'orden_id');
    }

    public function comentarios()
    {
        return $this->hasMany(trabajos_archivos::class, 'archivo_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'idEmpresa');
    }
    

}
