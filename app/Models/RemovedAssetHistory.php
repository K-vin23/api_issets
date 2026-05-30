<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemovedAssetHistory extends Model
{
    use HasFactory;

    protected $table = 'removed_asset_history';

    protected $primaryKey = 'removedId';
    public $timestamps = false;

    protected $fillable = [
        'assetId',
        'assetType',
        'serialNumber',
        'internalId',
        'brand',
        'model',
        'companyId',
        'companyName',
        'lastUser',
        'userName',
        'removalReason',
        'removalDate',
        'removedBy',
        'remUserName',
        'details'
    ];

    protected $casts = [
        'details'   => 'array'
    ];
    
    // Scopes
    public function scopeSearch($query, string $term) {
        return $query->where(function ($q) use($term) {
            $q->where('internalId', 'ILIKE', "%$term%")
            ->orWhere('brand', 'ILIKE', "%$term%")
            ->orWhere('model', 'ILIKE', "%$term%");
        });
    }

    // Artificial relations
    public function asset() {
        return $this->belongsTo(Asset::class, 'assetId', 'assetId');
    }
}