<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'users';

    protected $primaryKey = 'userId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'rolId',
        'companyId',
        'firstname',
        'middlename',
        'lastname',
        's_lastname',
        'email',
        'pw_encrypt',
        'areaId',
        'locationId',
        'registDate',
        'registBy',
        'isActive'
    ];

    protected $hidden = ['pw_encrypt'];

    public function getAuthPassword()
    {
        return $this->pw_encrypt;
    }

    protected function pwEncrypt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value) 
        );
    }

    // Shorcuts
    public function getFullName() :string
    {
        return "{$this->firstname} {$this->middlename} {$this->lastname} {$this->s_lastname}";
    }

    public function isAdmin(): bool {
        return $this->rolId === 'ADM';
    }

    public function isTec(): bool {
        return $this->rolId === 'TEC';
    }

    // Scopes

    public function scopeActive($query) {
        return $query->where('isActive', true);
    }

    public function scopeCompany($query, int $companyId) {
        return $query->where('companyId', $companyId);
    }

    public function scopeArea($query, int $areaId) {
        return $query->where('areaId', $areaId);
    }

    public function scopeLocation($query, int $locationId) {
        return $query->where('locationId', $locationId);
    }

    public function scopeSearch($query, string $term) {
        return $query->where(function ($q) use ($term) {
            $q->where('userId', 'ILIKE', "%$term%")
            ->orWhere('firstname', 'ILIKE', "%$term%")
            ->orWhere('middlename', 'ILIKE', "%$term%")
            ->orWhere('lastname', 'ILIKE', "%$term%")
            ->orWhere('s_lastname', 'ILIKE', "%$term%");
        });
    }

    // Relations
    public function rol() {
        return $this->belongsTo(Rol::class, 'rolId', 'rolId');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'companyId', 'companyId');
    }

    public function area() {
        return $this->belongsTo(Area::class, 'areaId', 'areaId');
    }

    public function location() {
        return $this->belongsTo(Location::class, 'locationId', 'locationId');
    }

    public function registeredBy() {
        return $this->belongsTo(User::class, 'registBy', 'userId');
    }

    public function configs() {
        return $this->hasMany(UserConfigs::class, 'userId', 'userId');
    }

    public function assetRegistered() {
        return $this->hasMany(Asset::class, 'registeredBy', 'userId');
    }

    public function computerAssigned() {
        return $this->hasMany(Computer::class, 'assignedUser', 'userId');
    }

    public function computerAssignedBy() {
        return $this->hasMany(Computer::class, 'assignedBy', 'userId');
    }

    public function maintenanceTechnician() {
        return $this->hasMany(Maintenance::class, 'tecId', 'userId');
    }

    public function registeredUsers() {
        return $this->hasMany(User::class, 'registBy', 'userId');
    }

}