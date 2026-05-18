<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentCategory extends Model
{
    use HasFactory;

    protected $table = 'component_category';

    protected $primaryKey = 'categoryId';
    public $timestamps = false;

    protected $fillable = [
        'category'
    ];
    
    // Relations
    public function types() {
        return $this->hasMany(ComponentType::class, 'categoryId', 'categoryId');
    }
}