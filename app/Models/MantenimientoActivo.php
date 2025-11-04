<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class MantenimientoActivo extends Model
{
    use HasFactory, Compoships;

    protected $table = 'system.mantenimiento_activo';

    protected $primaryKey = 'id_mant';
    public $incrementing = true; // es autoincremental
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_activo',
        'id_empresa',
        'id_tipomnt',
        'fecha_manten',
        'proximo_manten',
        'usr_manten',
        'ultima_act',
        'observaciones'
    ];

    // Llaves foraneas
    public function activo() { //Cada mantenimiento es sobre un activo
        return $this->belongsTo(Activo::class, ['id_activo', 'id_empresa'], ['id_activo', 'id_empresa']);
    }

    public function tipoMantenimiento() { //Cada mantenimiento es de un tipo especifico
        return $this->belongsTo(TipoMantenimiento::class, 'id_tipomnt', 'id_tipomnt');
    }

    public function usuarioMantenimiento() { //Cada mantenimiento es registrado por un usuario
        return $this->belongsTo(Usuario::class, 'usr_manten', 'cedula');
    }
}