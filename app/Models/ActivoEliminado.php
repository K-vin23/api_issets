<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class ActivoEliminado extends Model
{
    use HasFactory, Compoships;

    protected $table = 'system.activos_eliminados';

    protected $primaryKey = 'id_eliminado';
    public $incrementing = true; // es autoincremental
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_activo',
        'id_empresa',
        'ultimo_usr',
        'ultima_act',
        'usr_registro',
        'fecha_baja',
        'razon_baja'
    ];

    // Llaves foraneas
    public function activo()
    {
        return $this->belongsTo(Activo::class, ['id_activo', 'id_empresa'], ['id_activo', 'id_empresa']);
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');//Cada activo pertenece a una empresa
    }

    public function ultimoUsuario() { //Cada activo eliminado pertenecia a un usuario
        return $this->belongsTo(Usuario::class, 'ultimo_usr', 'cedula');
    }

    public function usuarioEliminacion() { //Cada activo eliminado lo registra un usuario
        return $this->belongsTo(Usuario::class, 'usr_registro', 'cedula');
    }

    // Accesos directos
}