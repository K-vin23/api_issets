<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'system.ciudad'; 

    protected $primaryKey = 'id_ciudad';
    public $incrementing = false; // no es autoincremental
    protected $keyType = 'string'; // 
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_ciudad',
        'nombre'
    ];

    // Llaves foraneas
    
    // Relaciones uno a muchos
    public function usuariosCiudad() { //una ciudad puede tener varios usuarios
        return $this->hasMany(Usuario::class, 'id_ciudad', 'id_ciudad');
    }

    public function empresasCiudad() { //una ciudad puede tener varias empresas
        return $this->hasMany(Empresa::class, 'id_ciudad', 'id_ciudad');
    }
}