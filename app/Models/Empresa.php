<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Empresa extends Model
{
    use HasFactory, Compoships;

    protected $table = 'system.empresa';
    protected $primaryKey = 'id_empresa';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa', 
        'nombre', 
        'id_ciudad'];
    
    // Llaves foraneas
    public function ciudad() {
        return $this->belongsTo(Ciudad::class, 'id_ciudad', 'id_ciudad');
    }

    // Relaciones uno a muchos
    public function activosEmpresa() {
        return $this->hasMany(Activo::class, 'id_empresa', 'id_empresa'); //una empresa tiene muchos activos
    }

    public function usuariosEmpresa() {
        return $this->hasMany(Usuario::class, 'id_empresa', 'id_empresa'); //una empresa tiene muchos usuarios
    }
}