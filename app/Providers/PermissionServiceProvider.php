<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        // $permissions = ItemPermission::group('modules')
        //     ->addPermission('clinic.view', 'Access to view clinics')
        //     ->addPermission('clinic.create', 'Access to create clinics')
        //     ->addPermission('clinic.edit', 'Access to edit clinics')
        //     ->addPermission('clinic.delete', 'Access to delete clinics');

        // $dashboard->registerPermissions($permissions);
    }
}
