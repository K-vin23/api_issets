<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAssignationHistory extends Model
{
    use HasFactory;

    protected $table = 'asset_assignation_history';
    protected $primaryKey = 'assignId';
    public $timestamps = false;

    protected $fillable = [
        'assignationType',
        'assetId',
        'serialNumber',
        'userId',
        'userName',
        'assignedBy',
        'assignName',
        'assignmentDate',
        'unassigmentDate'
    ];

    protected $casts = [
        'assignmentDate' => 'date',
        'unassigmentDate' => 'date',
        'assignationType'  => AssignmentType::class
    ];

    // Relations
    public function asset() {
        return $this->belongsTo(Asset::class, 'assetId', 'assetId');
    }

    public function assignedTo() {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    public function assignedBy() {
        return $this->belongsTo(User::class, 'assignedBy', 'userId');
    }
}
