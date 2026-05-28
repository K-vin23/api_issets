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
        'type',
        'maintenanceDate',
        'tecId',
        'observations'
    ];

    // Scopes
    public function scopeType($query, string $type) {
        return $query->where('type', $type);
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

    public function technician() {
        return $this->belongsTo(User::class, 'tecId', 'userId');
    }

    public function changes() {
        return $this->hasMany(ChangeAssetHistory::class, 'maintenanceId', 'maintenanceId');
    }
}