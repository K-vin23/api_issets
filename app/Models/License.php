<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $primaryKey = 'licenseId';
    public $timestamps = false;

    protected $fillable = [
        'providerId',
        'softwareType',
        'software',
        'sofVersion'
    ];

    // Relations
    public function licenseProvider() {
        return $this->belongsTo(LicenseProvider::class, 'providerId', 'providerId');
    }

    public function softwareType() {
        return $this->belongsTo(SoftwareType::class, 'softwareType', 'typeId');
    }

    public function computerLicenses() {
        return $this->hasMany(ComputerLicense::class, 'licenseId', 'licenseId');
    }
}