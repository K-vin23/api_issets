<?php

namespace App\Models;

use App\Enums\ChangeComponent;
use App\Enums\ChangeAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeType extends Model
{
    use HasFactory;

    protected $table = 'change_type';

    protected $primaryKey = 'changeTypeId';
    public $timestamps = false;

    protected $fillable = [
        'component',
        'action'
    ];

    protected $casts = [
        'component' => ChangeComponent::class,
        'action'    => ChangeAction::class
    ];
    
    // Relations
    public function changeAssetHistory() {
        return $this->hasMany(ChangeAssetHistory::class, 'changeTypeId', 'changeTypeId');
    }
}
