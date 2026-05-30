<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ChangeType;

class ChangeAssetHistory extends Model
{
    use HasFactory;

    protected $table = 'change_asset_history';

    protected $primaryKey = 'changeId';
    public $timestamps = false;

    protected $fillable = [
        'maintenanceId',
        'changetype',
        'description',
        'changeDate'
    ];

    protected $casts = [
        'changetype' => changeType::class
    ];

    // Relations
    public function asset() {
        return $this->belongsTo(Asset::class, 'assetId', 'assetId');
    }

    public function maintenance() {
        return $this->belongsTo(Maintenance::class, 'maintenanceId', 'maintenanceId');
    }

    public function changeType() {
        return $this->belongsTo(ChangeType::class, 'changeTypeId', 'changeTypeId');
    }
}   
