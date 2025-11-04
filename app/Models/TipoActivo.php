<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoActivo extends Model
{
    protected $table = 'system.tipo_activo';
    protected $primaryKey = 'id_tipoact';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_tipoact', 'tipo_activo'];

    // Relaciones uno a muchos
    public function activos() { //un tipo de activo puede pertenecer a multiples activos
        return $this->hasMany(Activo::class, 'tipo_act', 'id_tipoact');
    }
}