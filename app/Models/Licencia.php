<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    use HasFactory;

    protected $table = 'system.licencia';

    protected $primaryKey = 'id_licencia';
    public $incrementing = true; // Le decimos a Laravel que no es autoincremental
    public $timestamps = false; // si tu tabla no tiene created_at y updated_at

    protected $fillable = [
        'proveedor',
        'software',
        'version_software',
        'idioma',
    ];

    // Relaciones uno a muchos
    public function activoLicencias() {
        return $this->hasMany(ActivoLicencia::class, 'id_licencia', 'id_licencia'); //Una licencia puede estar asignada a muchos activos
    }
}