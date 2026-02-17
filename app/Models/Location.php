<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $primaryKey = 'locationId';
    public $timestamps = false;

    protected $fillable = [
        'locationId',
        'companyId',
        'cityId',
        'locationName'
    ];

    // Relations
    public function company() {
        return $this->belongsTo(Company::class, 'companyId', 'companyId');
    }

    public function city() {
        return $this->belongsTo(City::class, 'cityId', 'cityId');
    }

    public function users() {
        return $this->hasMany(User::class, 'locationId', 'locationId');
    }
}