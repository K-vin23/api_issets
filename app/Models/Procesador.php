<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Procesador extends Model
{
    use HasFactory, Compoships;

    protected $table = 'system.procesador';

    protected $primaryKey = 'id_proces';
    public $incrementing = true; // es autoincremental
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_proces',
        'marca',
        'familia_modelo',
        'numero_modelo'
    ];
    
    // Relaciones uno a muchos
    public function fichasActivo() { //Un tipo de procesador puede pertenecer a varios activos
        return $this->hasMany(FichaActivo::class, 'id_proces', 'id_proces');
    }
}