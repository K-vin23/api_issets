<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Maintenance extends Model
{
    use HasFactory;

    protected $primaryKey = 'maintenanceId';
    public $timestamps = false;

    protected $fillable = [
        'assetId',
        'typeId',
        'maintenanceDate',
        'nextMaintenance',
        'tecId',
        'observations'
    ];

    // Scopes
    public function scopeType($query, string $typeId) {
        return $query->where('typeId', $typeId);
    }

    public function scopeDate($query, string $date) {
        return $query->whereDate('maintenanceDate', $date);
    }

    public function scopeDateBetween($query, string $from, string $to) {
        return $query->whereBetween('maintenanceDate', [$from, $to]);
    }

    // Relations
    public function asset() {
        return $this->belongsTo(Asset::class, 'assetId', 'assetId');
    }

    public function maintenanceType() { 
        return $this->belongsTo(MaintenanceType::class, 'typeId', 'typeId');
    }

    public function technician() {
        return $this->belongsTo(User::class, 'tecId', 'cedula');
    }

    public function changes() {
        return $this->hasMany(ChangeAssetHistory::class, 'maintenanceId', 'maintenanceId');
    }
}