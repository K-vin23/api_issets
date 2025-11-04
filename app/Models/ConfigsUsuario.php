<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigsUsuario extends Model
{
    use HasFactory;

    protected $table = 'system.configs_usuario'; 

    public $incrementing = false; // no es autoincremental
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'cedula',
        'id_config',
        'valor'
    ];

    // Llaves foraneas
    public function usuario() {  //una configuracion pertenece a un usuario por registro
        return $this->belongsTo(Usuario::class, 'cedula', 'cedula');
    }

    public function configuracion() { //una configuracion puede tener un tipo de configuracion por registro
        return $this->belongsTo(Configs::class, 'id_config', 'id_config');
    }
}