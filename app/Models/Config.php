<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'config'; 

    protected $primaryKey = 'configId';
    public $timestamps = false;

    protected $fillable = [
        'config'
    ];

    // Relations
    public function userConfigs() { 
        return $this->hasMany(UserConfigs::class, 'configId', 'configId');
    }
}