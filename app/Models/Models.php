<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Models extends Model
{
    use HasFactory;

    protected $table = 'models';
    protected $primaryKey = 'modelId';
    public $timestamps = false;

    protected $fillable = [
        'brandId',
        'typeId', 
        'modelFamily',
        'modelSerie',
    ];

    // Scopes

    public function scopeBrand($query, string $brandId){
        return $query->where('brandId', $brandId);
    }

    public function scopeSearch($query, string $term) {
        $terms = explode(' ', trim($term));

        return $query->where(function ($q) use ($terms) {
            foreach ($terms as $t) {
                $q->where(function ($sub) use ($t) {
                    $sub->where('modelFamily', 'ILIKE', "%$t%")
                        ->orWhere('modelSerie', 'ILIKE', "%$t%")
                        ->orWhereHas('brands', fn($q) =>
                            $q->where('brand', 'ILIKE', "%$t%"));
                });
            }
        });
    }

    public function getModelNameAttribute(): string {
        return "{$this->modelFamily} {$this->modelSerie}";
    }

    // Relations
    public function brands() {
        return $this->belongsTo(Brand::class, 'brandId', 'brandId');
    }

    public function types() {
        return $this->belongsTo(AssetType::class, 'typeId', 'typeId');
    }

    public function assets() {
        return $this->hasMany(Asset::class, 'modelId', 'modelId');
    }

    public function modelComponents() {
        return $this->hasMany(ModelComponent::class, 'modelId', 'modelId');
    }
}