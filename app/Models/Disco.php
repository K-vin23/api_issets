<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Disco extends Model
{
    use HasFactory, Compoships;

    protected $table = 'system.disco_duro'; 

    protected $primaryKey = 'id_disco';
    public $incrementing = false; // no es autoincremental
    protected $keyType = 'string'; // 
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'tipo',
        'capacidad',
        'interfaz'
    ];

    // Llaves foraneas
    
    // Relaciones uno a muchos
    public function fichasActivo() { //un tipo de disco puede pertenecer a varios activos
        return $this->hasMany(FichaActivo::class, 'id_disco', 'id_disco');
    }

    //Acceso directo a los activos que tienen el disco
    public function activos(){ //Varios tipos de disco pueden pertenecer a varios activos (1 disco -> 2 activos; 1 activo -> 2 discos)
        return $this->belongsToMany(
            Activo::class,
            'system.ficha_activo',
            'id_disco',
            ['id_activo', 'id_empresa']
        );
    }
}