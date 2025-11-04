<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memoria extends Model
{
    use HasFactory;

    protected $table = 'system.memoria';

    protected $primaryKey = 'id_memo';
    public $incrementing = false; // no es autoincremental
    protected $keyType = 'string'; // Tipo de la primary key
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_memo',
        'tipo',
        'capacidad'
    ];

    // Relaciones uno a muchos
    public function fichasActivo() { //un tipo de memoria puede pertenecer a varios activos
        return $this->hasMany(FichaActivo::class, 'id_memo', 'id_memo');
    }
    
    //Acceso directo a los activos que tienen la memoria
    public function activos(){ //Varios tipos de memoria pueden pertenecer a varios activos (1 memoria -> 2 activos; 1 activo -> 2 memorias)
        return $this->belongsToMany(
            Activo::class,
            'system.ficha_activo',
            'id_memo',
            ['id_activo', 'id_empresa']
        );
    }
}