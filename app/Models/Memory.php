<?php

namespace App\Models;

use App\Enums\MemoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    use HasFactory;

    protected $primaryKey = 'memoryId';
    public $timestamps = false;

    protected $fillable = [
        'memoryType',
        'gbCapacity'
    ];

    protected $casts = [
        'memoryType' => MemoryType::class
    ];

    // Relations
    public function computerMemories() {
        return $this->hasMany(ComputerMemory::class, 'memoryId', 'memoryId');
    }

    public function computerModelMemories() {
        return $this->hasMany(ComputerModelMemory::class, 'memoryId', 'memoryId');
    }
}