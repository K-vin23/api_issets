<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class FichaActivo extends Model
{
    use HasFactory, Compoships;

    protected $table = 'system.ficha_activo'; // nombre exacto de tu tabla en PostgreSQL

    protected $primaryKey = 'id';
    public $incrementing = true; // es autoincremental
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_activo',
        'id_empresa',
        'id_memo',
        'slot_memo',
        'id_disco',
        'slot_disco',
        'id_proces',
        'extras'
    ];

    // Llaves foraneas
    public function memoria() { //Una ficha puede tener una memoria por registro
        return $this->belongsTo(Memoria::class, 'id_memo', 'id_memo');
    }

    public function disco() { //Una ficha puede tener un disco por registro
        return $this->belongsTo(Disco::class, 'id_disco', 'id_disco');
    }

    public function procesador() { //Una ficha puede tener un procesador
        return $this->belongsTo(Procesador::class, 'id_proces', 'id_proces');
    }

    public function activo() { //Una ficha solo pertenece a un activo por registro
        return $this->belongsTo(Activo::class, ['id_activo', 'id_empresa'], ['id_activo', 'id_empresa']);
    }
}