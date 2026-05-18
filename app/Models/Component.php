<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $table = 'components';

    protected $primaryKey = 'componentId';
    public $timestamps = false;

    protected $fillable = [
        'ctypeId',
        'component'
    ];

    // Scopes
     public function scopeCategory($query, string $categoryId)
    {
        return $query->whereHas(
            'compType.category',
            fn($q) => $q->where('categoryId', $categoryId)
        );
    }
    
    // Relations
    public function compType() {
        return $this->belongsTo(ComponentType::class, 'ctypeId', 'ctypeId');
    }

    public function assetComponents() {
        return $this->hasMany(AssetComponent::class, 'componentId', 'componentId');
    }

    public function modelComponents() {
        return $this->hasMany(ModelComponent::class, 'componentId', 'componentId');
    }

    public function getComponentNameAttribute(): string {
        return "{$this->component} {$this->compType->compType}";
    }
}