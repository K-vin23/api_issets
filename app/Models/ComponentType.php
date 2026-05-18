<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentType extends Model
{
    use HasFactory;

    protected $table = 'component_type';

    protected $primaryKey = 'ctypeId';
    public $timestamps = false;

    protected $fillable = [
        'categoryId',
        'compType'
    ];
    
    // Relations
    public function category() {
        return $this->belongsTo(ComponentCategory::class, 'categoryId', 'categoryId');
    }

    public function components() {
        return $this->hasMany(Component::class, 'ctypeId', 'ctypeId');
    }
}