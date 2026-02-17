<?php

namespace App\Models;

use App\Enums\ProcessManufact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processor extends Model
{
    use HasFactory;

    protected $primaryKey = 'processorId';
    public $timestamps = false;

    protected $fillable = [
        'manufacturer',
        'processorModel'
    ];

    protected $casts = [
        'maufacturer' => ProcessManufact::class
    ];

    public function getProcessor() {
        return "{$this->manufacturer} {$this->processorModel}";
    }
    
    // Relations
    public function computerModels() {
        return $this->hasMany(ComputerModel::class, 'processorId', 'processorId');
    }
}