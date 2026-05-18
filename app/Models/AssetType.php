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

    //Shortcuts
    public function isComputer(): bool {
        return in_array($this->typeId, ['LAP', 'SFF', 'TORR']);
    }

    public function isMonitor(): bool {
        if($this->typeId === 'MON'){
            return true;
        } else {
            return false;
        };
    }

    public function isUps(): bool {
        if($this->typeId === 'UPS'){
            return true;
        } else {
            return false;
        };
    }

     // Relations
    public function assets() {
        return $this->hasMany(Asset::class, 'typeId', 'typeId');
    }
}