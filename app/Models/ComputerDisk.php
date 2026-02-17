<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerDisk extends Model
{
    use HasFactory;

    protected $table = 'computer_disk';
    public $timestamps = false;

    protected $fillable = [
        'computerId',
        'diskId',
        'lastUpdate'
    ];

    // Relations
    public function computer() {
        return $this->belongsTo(Computer::class, 'computerId', 'computerId');
    }
    
    public function disk() {
        return $this->belongsTo(HardDisk::class, 'diskId', 'diskId');
    }
}
