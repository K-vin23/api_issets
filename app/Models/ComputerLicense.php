<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerLicense extends Model
{
    use HasFactory;

    protected $table = 'computer_license';
    public $timestamps = false;

    protected $fillable = [
        'computerId',
        'licenseId',
        'licenseKey'
    ];

    // Relations
    public function computer() {
        return $this->belongsTo(Computer::class, 'computerId', 'computerId');
    }

    public function license() {
        return $this->belongsTo(License::class, 'licenseId', 'licenseId');
    }
}
