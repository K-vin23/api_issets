<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    protected $primaryKey = 'companyId';
    public $timestamps = false;

    protected $fillable = [ 
        'company',
        'status'
    ];

    // Shortcuts
    public function getStatusAttribute($value): string {
        return $value === 'A' ? 'Active' : 'Inactive';
    }
    
    // Relations
    public function locations() {
        return $this->hasMany(Location::class, 'companyId', 'companyId');
    }

    public function users() {
        return $this->hasMany(User::class, 'companyId', 'companyId');
    }

    public function assets() {
        return $this->hasMany(Asset::class, 'companyId', 'companyId');
    }

    public function computers() {
        return $this->hasMany(Computer::class, 'companyId', 'companyId');
    }
}