<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerModelMemory extends Model
{
    use HasFactory;

    protected $table = 'computer_model_memory';
    public $timestamps = false;

    protected $fillable = [
        'modelId',
        'memoryId'
    ];

    // Relations
    public function model() {
        return $this->belongsTo(ComputerModel::class, 'modelId', 'modelId');
    }

    public function memory() {
        return $this->belongsTo(Memory::class, 'memoryId', 'memoryId');
    }
}
