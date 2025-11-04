<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelosActivo extends Model
{
    use HasFactory;

    protected $table = 'system.modelos_activo';
    protected $primaryKey = 'id_modelo';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_marca', 
        'familia_modelo',
        'numero_modelo',
        'modelo'
    ];

    // Llaves foraneas
    public function marcaModelo() { //Cada modelo tiene una marca
        return $this->belongsTo(MarcasActivo::class, 'id_marca', 'id_marca');
    }

    // Relaciones uno a muchos
    public function activos() { //Un modelo puede estar presente en varios activos
        return $this->hasMany(Activo::class, 'id_modelo', 'id_modelo');
    }
}