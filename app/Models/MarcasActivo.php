<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcasActivo extends Model
{
    use HasFactory;
    
    protected $table = 'system.marcas_activo';

    protected $primaryKey = 'id_marca';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_marca', 'marca'];

    // Relaciones uno a muchos
    public function modelos() { //una marca puede tener varios modelos
        return $this->hasMany(ModelosActivo::class, 'id_marca', 'id_marca');
    }
}