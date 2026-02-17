<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerMemory extends Model
{
    use HasFactory;

    protected $table = 'computer_memory';
    public $timestamps = false;

    protected $fillable = [
        'computerId',
        'memoryId',
        'lastUpdate'
    ];

    // Relations
    public function computer() {
        return $this->belongsTo(Computer::class, 'computerId', 'computerId');
    }

    public function memory() {
        return $this->belongsTo(Memory::class, 'memoryId', 'memoryId');
    }
}
