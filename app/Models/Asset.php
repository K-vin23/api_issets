<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $primaryKey = 'assetId';
    public $timestamps = false; 

    protected $fillable = [
        'companyId',
        'areaId',
        'typeId',
        'modelId',
        'serialNumber',
        'internalId',
        'invoice',
        'purchaseDate',
        'networkName',
        'assignedUser',
        'details',
        'lastUpdate',
        'isActive',
        'registeredBy',
    ];

    protected $casts = [
        'purchaseDate' => 'date',
        'lastUpdate' => 'date',
    ];

    //Shortcuts
    public function isComputer(): bool {
        return $this->type?->isComputer() ?? false;
    }

    public function isMonitor(): bool { 
        return $this->type?->isMonitor() ?? false;
    }

    public function isUps(): bool {
        return $this->type?->isUps() ?? false;
    }

    // Scopes

    public function scopeCompany($query, int $companyId) {
        return $query->where('companyId', $companyId);
    }

    public function scopeType($query, string $assetType) {
        return $query->where('assetType', $assetType);
    }
    
    // Scope for isActive, not for user assigned
    public function scopeStatus($query, string $status) {
        if($status === 'active'){
            return $query->where('isActive', true);
        } else if ($status === 'inactive') {
            return $query->where('isActive', false);
        }else{
            return;
        }
    }

    // public function scopeSearch($query, string $term) {
    //     return $query->where(function ($q) use($term) {
    //         $q->where('internalId', 'ILIKE', "%$term%")
    //         ->orWhere('internalId', 'ILIKE')
    //     });
    // }

    // Relations
    public function company() {
        return $this->belongsTo(Company::class, 'companyId', 'companyId');
    }

    public function area() {
        return $this->belongsTo(Area::class, 'areaId', 'areaId');
    }

    public function type() {
        return $this->belongsTo(AssetType::class, 'typeId', 'typeId');
    }

    public function assetModels() {
        return $this->belongsTo(Models::class, 'modelId', 'modelId');
    }

    public function assignedTo() {
        return $this->belongsTo(User::class, 'assignedUser', 'userId');
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

    public function usersHistory() {
        return $this->hasMany(AssetAssignationHistory::class, 'assetId', 'assetId');
    }

    public function components() {
        return $this->hasMany(AssetComponent::class, 'assetId', 'assetId');
    }

    public function licenses() {
        return $this->hasMany(AssetLicense::class, 'assetId', 'assetId');
    }
}