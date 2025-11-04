<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class ActivoLicencia extends Model
{
    use HasFactory, Compoships;

    protected $table = 'system.activo_licencia';
    protected $primaryKey = 'id';
    public $incrementing = true; // es autoincremental
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_activo',
        'id_empresa',
        'id_licencia',
        'clave_encrypt',
    ];

    // Llaves foraneas
    public function activo() {//Cada activo tiene una licencia
        return $this->belongsTo(Activo::class, ['id_activo', 'id_empresa'], ['id_activo', 'id_empresa']);
    }

    public function licencia() {
        return $this->belongsTo(Licencia::class, 'id_licencia', 'id_licencia');
    }
}