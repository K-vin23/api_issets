<?php

namespace App\Models;

use App\Enums\AuditAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audit';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'afTable',
        'afRecord',
        'apAction',
        'dataBefore',
        'dataAfter',
        'userId',
        'userName',
        'apDate'
    ];

    protected $casts = [
        'apAction'     => AuditAction::class,
        'dataBefore'   => 'array',
        'dataAfter'    => 'array',
        'apDate'       => 'datetime'
    ];

    //It's a audit table, so no relations are defined.
}
