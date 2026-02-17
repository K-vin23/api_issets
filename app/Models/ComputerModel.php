<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComputerModel extends Model
{
    use HasFactory;

    protected $table = 'computer_models';
    protected $primaryKey = 'modelId';
    public $timestamps = false;

    protected $fillable = [
        'brandId', 
        'modelFamily',
        'modelSerie',
        'processorId'
    ];

    // Scopes

    public function scopeBrand($query, string $brandId){
        return $query->where('brandId', $brandId);
    }

    public function scopeSearch($query, string $term) {
        return $query->where(function ($q) use ($term) {
                $q->where('modelFamily', 'ILIKE', "%$term%")
                ->orWhere('modelSerie', 'ILIKE', "%$term%"); 
        });
    }

    public function getModelName() {
        return "{$this->modelFamily} {$this->modelSerie}";
    }

    // Relations
    public function computerBrand() {
        return $this->belongsTo(ComputerBrand::class, 'brandId', 'brandId');
    }

    public function processor() {
        return $this->belongsTo(Processor::class, 'processorId', 'processorId');
    }

    public function computers() {
        return $this->hasMany(Computer::class, 'modelId', 'modelId');
    }

    public function disks() {
        return $this->hasMany(ComputerModelDisk::class, 'modelId', 'modelId');
    }

    public function memories() {
        return $this->hasMany(ComputerModelMemory::class, 'modelId', 'modelId');
    }
}