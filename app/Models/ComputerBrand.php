<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerBrand extends Model
{
    use HasFactory;
    
    protected $table = 'computer_brands';

    protected $primaryKey = 'brandId';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'brandId', 
        'brand'
    ];

    // Relations
    public function computerModels() {
        return $this->hasMany(ComputerModel::class, 'brandId', 'brandId');
    }
}