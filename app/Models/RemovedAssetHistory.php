<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemovedAssetHistory extends Model
{
    use HasFactory;

    protected $table = 'removed_asset_history';

    protected $primaryKey = 'removedId';
    public $timestamps = false;

    protected $fillable = [
        'assetType',
        'serialNumber',
        'companyId',
        'companyName',
        'removalDate',
        'removedBy',
        'remUserName'
    ];

    //It's a historical table
    public function removedComputer() {
        return $this->hasOne(RemovedComputerHistory::class, 'removedId', 'remAssetId');
    }
}