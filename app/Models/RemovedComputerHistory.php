<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemovedComputerHistory extends Model
{
    use HasFactory;

    protected $table = 'removed_computer_history';
    protected $primaryKey = 'removedId';
    public $timestamps = false;

    protected $fillable = [
        'remAssetId',
        'internalId',
        'brand',
        'model',
        'companyId',
        'companyName',
        'lastAssignedUser',
        'userName',
        'lastUpdate',
        'removalReason',
        'removedBy',
        'remUserName'
    ];

    //It's a historical table, but have exception with the removedId from the asset deleted
    public function removedAsset() {
        return $this->belongsTo(RemovedAssetHistory::class, 'remAssetId', 'removedId');
    }
}
