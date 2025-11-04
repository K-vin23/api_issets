<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Awobaz\Compoships\Compoships; // Importar el trait

class Activo extends Model
{
    use HasFactory, Compoships;

    protected $table = 'system.activo';

    protected $primaryKey = ['id_activo', 'id_empresa'];  // Llave compuesta
    public $incrementing = false; // no es autoincremental
    protected $keyType = 'string'; // Tipo de la primary key
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'id_activo',
        'id_tipoact',
        'id_modelo',
        'id_empresa',
        'usr_asignado',
        'factura_compra',
        'fecha_compra',
        'usr_registro',
        'ultima_act'
    ];

    public static function getActivosEmpresa($id_empresa)
    {
        return collect(DB::select('SELECT * FROM system.get_activos_empresa(?)', [$id_empresa]));
    }

    //corregir el bendito error de Illegal offset type
    public function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();

        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getAttribute($keyName));
        }

        return $query;
    }

    // Llaves foraneas
    public function tipoActivo() {
        return $this->belongsTo(TipoActivo::class, 'id_tipoact', 'id_tipoact');
    }

    public function modelo() {
        return $this->belongsTo(ModelosActivo::class, 'id_modelo', 'id_modelo'); //Cada activo pertenece a un modelo
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');//Cada activo pertenece a una empresa
    }

    public function usuarioAsignado() {
        return $this->belongsTo(Usuario::class, 'usr_asignado', 'cedula');//Cada activo tiene un usuario asignado
    }

    public function usuarioRegistro() {
        return $this->belongsTo(Usuario::class, 'usr_registro', 'cedula');//Cada activo es registrado por un usuario
    }

    public function activoEliminado()
    {
        return $this->hasOne(ActivoEliminado::class, ['id_activo', 'id_empresa'], ['id_activo', 'id_empresa']);
    }

    // Relaciones uno a muchos
    public function mantenimientos() { 
        return $this->hasMany(MantenimientoActivo::class, ['id_activo', 'id_empresa'], ['id_activo', 'id_empresa']);//Un activo tiene multiples mantenimientos
    }

    public function activoLicencias(){
        return $this->hasMany(ActivoLicencia::class, ['id_activo', 'id_empresa'], ['id_activo', 'id_empresa']);//Un activo puede tener multiples licencias, (Windows, Office, etc)
    }

    public function fichas(){
        return $this->hasMany(FichaActivo::class, ['id_activo', 'id_empresa'], ['id_activo', 'id_empresa']);//Un activo puede tener varias fichas (Doble disco, Doble ram..)
    }

    //Accesos directos
    //A los discos que tiene el activo
    public function discos(){ //Muchos activos pueden tener Varios discos (1 activo -> 2 discos; 2 activos -> 1 disco)
        return $this->belongsToMany(
            Disco::class,
            'system.ficha_activo',
            ['id_activo', 'id_empresa'],
            'id_disco'
        );
    }
    //A las memorias que tiene el activo
    public function memorias(){ //Muchos activos pueden tener Varios discos (1 activo -> 2 discos; 2 activos -> 1 disco)
        return $this->belongsToMany(
            Memoria::class,
            'system.ficha_activo',
            ['id_activo', 'id_empresa'],
            'id_memo'
        );
    }
}