<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'rolId';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'rolId',
        'rol'
    ];
    
    // Relactions
    public function user() { 
        return $this->hasMany(User::class, 'rolId', 'rolId');
    }
}
