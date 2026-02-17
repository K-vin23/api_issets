<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareType extends Model
{
    use HasFactory;

    protected $table = 'software_types';
    protected $primaryKey = 'typeId';
    public $timestamps = false;

    protected $fillable = [
        'softwareType'
    ];

    // Relations
    public function licenses() {
        return $this->hasMany(License::class, 'softwareType', 'typeId');
    }
}
