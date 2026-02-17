<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Asset;
use App\Models\Computer;
use App\Models\Maintenance;
use App\Models\User;
use App\Models\Company;
use App\Models\ComputerModel;
use App\Policies\AssetPolicy;
use App\Policies\UserPolicy;
use App\Policies\MaintenancePolicy;
use App\Policies\ComputerPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\CatalogPolicy;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Asset::class         => AssetPolicy::class,
        Computer::class      => ComputerPolicy::class,
        Maintenance::class   => MaintenancePolicy::class,
        User::class          => UserPolicy::class,
        Company::class       => CompanyPolicy::class,
        ComputerModel::class => CatalogPolicy::class 
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
