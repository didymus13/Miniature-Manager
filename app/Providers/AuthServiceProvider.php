<?php

namespace App\Providers;

use App\Collection;
use App\Miniature;
use App\Photo;
use App\Policies\CollectionPolicy;
use App\Policies\MiniaturePolicy;
use App\Policies\PhotoPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Collection::class => CollectionPolicy::class,
        Miniature::class => MiniaturePolicy::class,
        Photo::class => PhotoPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
