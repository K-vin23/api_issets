<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetLicense extends Model
{
    use HasFactory;

    protected $table = 'asset_license';
    public $timestamps = false;

    protected $fillable = [
        'assetId',
        'licenseId',
        'licenseKey'
    ];

    // Relations
    public function asset() {
        return $this->belongsTo(Asset::class, 'assetId', 'assetId');
    }

    public function license() {
        return $this->belongsTo(License::class, 'licenseId', 'licenseId');
    }
}
