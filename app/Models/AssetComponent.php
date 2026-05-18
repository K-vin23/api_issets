<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetComponent extends Model
{
    use HasFactory;

    protected $table = 'asset_components';
    public $timestamps = false;

    protected $fillable = [
        'assetId',
        'componentId'
    ];

    // Relations
    public function asset() {
        return $this->belongsTo(Asset::class, 'assetId', 'assetId');
    }
    
    public function component() {
        return $this->belongsTo(Component::class, 'componentId', 'componentId');
    }
}
