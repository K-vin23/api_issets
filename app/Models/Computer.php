<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $primaryKey = 'computerId';
    public $timestamps = false;

    protected $fillable = [
        'assetId',
        'internalId',
        'areaId',
        'modelId',
        'assignedUser',
        'assignedBy',
        'lastUpdate'
    ];
    // Shortcuts

    public function assignUser(int $userId, int $assignedBy) {
        if ($this->assignedUser === $userId) {
            return;
        }

        $this->update(['assignedUser' => $userId]);
        $this->update(['assignedBy' => $assignedBy]);
    }

    //  Scopes

    public function scopeCompany($query, int $companyId) {
        return $query->whereHas('asset', fn($q) => $q->where('companyId', $companyId));
    }

    public function scopeArea($query, int $areaId) {
        return $query->where('areaId', $areaId);
    }

    public function scopeModel($query, int $modelId) {
        return $query->where('modelId', $modelId);
    }

    public function scopeSearch($query, string $term) {
        return $query->where(function ($q) use ($term) {
            $q->where('internalId', 'ILIKE', "%$term%")
            ->orWhereHas('computerModel', function ($m) use ($term) {
                $m->where('modelFamily', 'ILIKE', "%$term%")
                ->orWhere('modelSerie', 'ILIKE', "%$term%");
            });
        });
    }

    // Relations
    public function asset() {
        return $this->belongsTo(Asset::class, 'assetId', 'assetId');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'companyId', 'companyId');
    }

    public function area() {
        return $this->belongsTo(Area::class, 'areaId', 'areaId');
    }

    public function computerModel() {
        return $this->belongsTo(ComputerModel::class, 'modelId', 'modelId');
    }

    public function assignedUser() {
        return $this->belongsTo(User::class, 'assignedUser', 'userId');
    }

    public function assignedByUser() {
        return $this->belongsTo(User::class, 'assignedBy', 'userId');
    }

    public function memories() {
        return $this->hasMany(ComputerMemory::class, 'computerId', 'computerId');
    }

    public function disks() {
        return $this->hasMany(ComputerDisk::class, 'computerId', 'computerId');
    }

    public function licenses() {
        return $this->hasMany(ComputerLicense::class, 'computerId', 'computerId');
    }

    public function userHistory() {
        return $this->hasMany(ComputerUserHistory::class, 'computerId', 'computerId');
    }
}
