<?php

namespace Reactor\Providers;


use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Reactor\ACL\Permission;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Reactor\Model' => 'Reactor\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        foreach ($this->getPermissions() as $permission)
        {
            $gate->define($permission->name, function ($user) use ($permission)
            {
                return ($user->hasPermission($permission->name) or $user->hasRole($permission->roles));
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
