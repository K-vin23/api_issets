<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $primaryKey = 'assetId';
    public $timestamps = false; 

    protected $fillable = [
        'serialNumber',
        'companyId',
        'assetType',
        'invoice',
        'purchaseDate',
        'registeredBy'
    ];

    //Shortcuts
    public function isComputer(): bool { // Determine if the asset is a computer
        return $this->type?->isComputer() ?? false;
    }

    // Scopes

    public function scopeCompany($query, int $companyId) {
        return $query->where('companyId', $companyId);
    }

    public function scopeType($query, string $assetType) {
        return $query->where('assetType', $assetType);
    }

    public function scopeSearch($query, string $term) {
        return $query->where(function ($q) use($term) {
            $q->where('serialNumber', 'ILIKE', "%$term%");
        });
    }

    // Relations
    public function company() {
        return $this->belongsTo(Company::class, 'companyId', 'companyId');
    }

    public function type() {
        return $this->belongsTo(AssetType::class, 'assetType', 'typeId');
    }

    public function registerUser() {
        return $this->belongsTo(User::class, 'registeredBy', 'userId');
    }

    public function maintenance() {
        return $this->hasMany(Maintenance::class, 'assetId', 'assetId');
    }

    public function changeAssetHistory() {
        return $this->hasMany(ChangeAssetHistory::class, 'assetId', 'assetId');
    }

    public function computer() {
        return $this->hasOne(Computer::class, 'assetId', 'assetId');
    }
}