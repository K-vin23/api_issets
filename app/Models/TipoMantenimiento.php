<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMantenimiento extends Model
{
    protected $table = 'system.tipo_mantenimiento';
    protected $primaryKey = 'id_tipomnt';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['tipo_mantenimiento'];
    
    // Relaciones uno a muchos
    public function mantenimientos() { //Varios mantenimientos pueden ser del mismo tipo
        return $this->hasMany(MantenimientoActivo::class, 'id_tipomnt', 'id_tipomnt');
    }
}
