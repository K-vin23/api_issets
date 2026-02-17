<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerModelDisk extends Model
{
    use HasFactory;

    protected $table = 'computer_model_disk';
    public $timestamps = false;

    protected $fillable = [
        'modelId',
        'diskId'
    ];

    // Relations
    public function model() {
        return $this->belongsTo(ComputerModel::class, 'modelId', 'modelId');
    }

    public function disk() {
        return $this->belongsTo(HardDisk::class, 'diskId', 'diskId');
    }
}
