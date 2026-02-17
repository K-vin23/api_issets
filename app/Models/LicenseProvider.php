<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseProvider extends Model
{
    use HasFactory;

    protected $table = 'license_providers';
    protected $primaryKey = 'providerId';
    public $timestamps = false;

    protected $fillable = [
        'provider'
    ];

    // Relations
    public function licenses() {
        return $this->hasMany(License::class, 'providerId', 'providerId');
    }
}
