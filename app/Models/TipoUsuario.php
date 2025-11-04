<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'system.tipo_usuario';
    protected $primaryKey = 'id_tipousr';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['tipo_usuario'];
    
    // Relaciones uno a muchos
    public function usuarios() { //Varios usuarios pueden ser del mismo tipo
        return $this->hasMany(Usuario::class, 'id_tipousr', 'id_tipousr');
    }
}
