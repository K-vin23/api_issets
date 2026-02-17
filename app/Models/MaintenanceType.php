<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceType extends Model
{
    protected $table = 'maintenance_types';
    protected $primaryKey = 'typeId';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'typeId',
        'maintenanceType'
    ];
    
    // Relations
    public function maintenance() {
        return $this->hasMany(Maintenance::class, 'typeId', 'typeId');
    }
}
