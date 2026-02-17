<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConfigs extends Model
{
    use HasFactory;

    protected $table = 'user_configs'; 

    public $timestamps = false;

    protected $fillable = [
        'cedula',
        'configId',
        'configValue'
    ];

    // Relations
    public function user() { 
        return $this->belongsTo(User::class, 'cedula', 'cedula');
    }

    public function config() { 
        return $this->belongsTo(Config::class, 'configId', 'configId');
    }
}