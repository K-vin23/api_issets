<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $primaryKey = 'areaId';
    public $timestamps = false; 
    protected $fillable = [
        'area'
    ];

    // Relations
    public function users() {
        return $this->hasMany(User::class, 'areaId', 'areaId');
    }

    public function computers() {
        return $this->hasMany(Computer::class, 'areaId', 'areaId');
    }
}