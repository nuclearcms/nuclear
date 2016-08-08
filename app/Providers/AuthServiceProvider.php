<?php

namespace Reactor\Providers;


use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Nuclear\Users\Permission;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        if (is_installed())
        {
            $this->registerReactorPolicies($gate);
        }
    }

    /**
     * Registers reactor policies
     *
     * @param GateContract $gate
     */
    protected function registerReactorPolicies(GateContract $gate)
    {
        $gate->before(function ($user, $ability)
        {
            if ($user->isSuperAdmin())
            {
                return true;
            }
        });

        foreach ($this->getPermissions() as $permission)
        {
            $gate->define($permission->name, function ($user) use ($permission)
            {
                return ($user->hasPermission($permission->name) || $user->hasRole($permission->roles));
            });
        }
    }

    /**
     * Helper for retrieving permissions
     *
     * @return Collection
     */
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
