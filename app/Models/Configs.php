<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configs extends Model
{
    use HasFactory;

    protected $table = 'system.configs'; 

    protected $primaryKey = 'id_config';
    public $incrementing = false; // no es autoincremental
    protected $keyType = 'string'; // 
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_config',
        'nombre'
    ];

    // Llaves foraneas
    
    // Relaciones uno a muchos
    public function configuracionUsuarios() { //Varios usuarios pueden tener un tipo de configuración
        return $this->hasMany(ConfigsUsuario::class, 'id_config', 'id_config');
    }
}