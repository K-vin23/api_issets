<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $table = 'asset_types';
    protected $primaryKey = 'typeId';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'typeId', 
        'assetType'
    ];
    
    // Relations
    public function assets() {
        return $this->hasMany(Asset::class, 'assetType', 'typeId');
    }

    //Shortcuts
    public function isComputer(): bool {
        return in_array($this->typeId, ['PORT', 'TORR', 'SFF'], true);
    }
}