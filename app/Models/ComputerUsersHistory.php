<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerUsersHistory extends Model
{
    use HasFactory;

    protected $table = 'computer_users_history';
    protected $primaryKey = 'historyId';
    public $timestamps = false;

    protected $fillable = [
        'computerId',
        'userId',
        'userName',
        'assignmentDate',
        'status'
    ];

    protected $casts = [
        'assignmentDate' => 'date',
        'status'         => AssignmentStatus::class
    ];

    // Relations
    public function computer() {
        return $this->belongsTo(Computer::class, 'computerId', 'computerId');
    }
}
