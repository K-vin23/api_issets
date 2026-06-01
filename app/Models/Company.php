<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    protected $primaryKey = 'companyId';
    public $timestamps = false;

    protected $fillable = [ 
        'company',
        'isActive'
    ];

    protected $casts = [
        'isActive'  => 'boolean'
    ];

    // Shortcuts
    public function getStatusAttribute(): string {
        return $this->isActive == true ? 'Active' : 'Inactive';
    }

    // Scopes
    public function scopeSearch($query, string $term) {
        $terms = explode(' ', trim($term));

        return $query->where(function ($q) use ($terms){
            foreach ($terms as $t ) {
                $q->where(function ($sub) use ($t) {
                    $sub->where('company', 'ILIKE', "%$t%")
                    ->orWhere('companyId', 'ILIKE', "%$t%");
                });
            }
        });
    }

    public function scopeActive($query, string $status) {
        if($status == 'Active'){
            return $query->where('isActive', true);
        } else {
            return $query->where('isActive', false);
        }
    }

    public function scopePrincipalLocation($query, string $name) {
        return $query->whereHas('locations', function ($q) use ($name) {
            $q->where('locationName', $name);
        });
    }
    
    // Relations
    public function locations() {
        return $this->hasMany(Location::class, 'companyId', 'companyId');
    }

    public function users() {
        return $this->hasMany(User::class, 'companyId', 'companyId');
    }

    public function assets() {
        return $this->hasMany(Asset::class, 'companyId', 'companyId');
    }
}