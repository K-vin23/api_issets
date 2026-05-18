<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    
    protected $table = 'brands';

    protected $primaryKey = 'brandId';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'brandId', 
        'brand'
    ];

    // Relations
    public function models() {
        return $this->hasMany(Model::class, 'brandId', 'brandId');
    }
}