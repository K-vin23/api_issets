<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'system.usuario'; // nombre exacto de tu tabla en PostgreSQL

    protected $primaryKey = 'cedula';
    public $incrementing = false; // no es autoincremental
    public $timestamps = false; // no tiene created_at y updated_at

    protected $fillable = [
        'cedula',
        'id_tipousr',
        'id_empresa',
        'nombre_completo',
        'correo',
        'id_ciudad',
        'pwd_encrypt'
    ];

    protected $hidden = ['pwd_encrypt'];

    // Llaves foraneas
    public function tipoUsuario() {
        return $this->belongsTo(TipoUsuario::class, 'id_tipousr', 'id_tipousr');
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }

    public function ciudad() {
        return $this->belongsTo(Ciudad::class, 'id_ciudad', 'id_ciudad');
    }

    public function configuracion() { //un usuario puede tener varias configuraciones
        return $this->hasMany(ConfigsUsuario::class, 'cedula', 'cedula');
    }

    //Gets
    public function getRolAttribute()
    {
        return $this->tipoUsuario->id_tipousr ?? 'SIN_ROL';
    }

    //encriptar la constrasena
    public function setPwdEncryptAttribute($value)
    {
        // Solo encripta si no está ya encriptada
        if (!empty($value) && !Hash::needsRehash($value)) {
            $this->attributes['pwd_encrypt'] = Hash::make($value);
        } else {
            $this->attributes['pwd_encrypt'] = $value;
        }
    }
}