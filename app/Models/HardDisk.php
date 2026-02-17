<?php

namespace App\Models;

use App\Enums\DiskType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardDisk extends Model
{
    use HasFactory;

    protected $table = 'hard_disks';

    protected $primaryKey = 'diskId';
    public $timestamps = false;

    protected $fillable = [
        'diskType',
        'gbCapacity'
    ];

    protected $casts = [
        'diskType' => DiskType::class
    ];
    
    // Relations
    public function computerDisks() {
        return $this->hasMany(ComputerDisk::class, 'diskId', 'diskId');
    }

    public function computerModelDisks() {
        return $this->hasMany(ComputerModelDisk::class, 'diskId', 'diskId');
    }
}