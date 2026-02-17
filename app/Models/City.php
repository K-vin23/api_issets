<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $primaryKey = 'cityId';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    public $timestamps = false; 

    protected $fillable = [
        'cityId',
        'city'
    ];
    
    // Relations
    public function location() { 
        return $this->hasMany(Location::class, 'cityId', 'cityId');
    }
}