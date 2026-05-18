<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelComponent extends Model
{
    use HasFactory;

    protected $table = 'model_components';
    public $timestamps = false;

    protected $fillable = [
        'modelId',
        'componentId'
    ];

    // Relations
    public function model() {
        return $this->belongsTo(Models::class, 'modelId', 'modelId');
    }

    public function component() {
        return $this->belongsTo(Component::class, 'componentId', 'componentId');
    }
}
