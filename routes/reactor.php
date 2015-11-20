<?php

Route::group(['prefix' => config('app.reactor_prefix')], function ()
{
    // Authentication
    Route::get('auth/login', [
        'uses' => 'Auth\AuthController@getLogin',
        'as'   => 'reactor.auth.login']);
    Route::post('auth/login', [
        'uses' => 'Auth\AuthController@postLogin',
        'as'   => 'reactor.auth.login.post']);
    Route::get('auth/logout', [
        'uses' => 'Auth\AuthController@getLogout',
        'as'   => 'reactor.auth.logout']);

    // Password Reset
    Route::get('password/email', [
        'uses' => 'Auth\PasswordController@getEmail',
        'as'   => 'reactor.password.email']);
    Route::post('password/email', [
        'uses' => 'Auth\PasswordController@postEmail',
        'as'   => 'reactor.password.email.post']);

    Route::get('password/reset/{token}', [
        'uses' => 'Auth\PasswordController@getReset',
        'as'   => 'reactor.password.reset']);
    Route::post('password/reset', [
        'uses' => 'Auth\PasswordController@postReset',
        'as'   => 'reactor.password.reset.post']);

    // General reactor group
    Route::group(['middleware' => ['auth', 'guard:ACCESS_REACTOR']], function ()
    {
        // Dashboard
        Route::get('/', [
            'uses' => 'DashboardController@index',
            'as'   => 'reactor.dashboard']);
        Route::get('dashboard/history', [
            'middleware' => 'guard:ACCESS_HISTORY',
            'uses'       => 'DashboardController@history',
            'as'         => 'reactor.dashboard.history']);

        // Profile
        Route::group(['prefix' => 'profile'], function ()
        {
            Route::get('/', [
                'uses' => 'ProfileController@edit',
                'as'   => 'reactor.profile.edit']);
            Route::put('/', [
                'uses' => 'ProfileController@update',
                'as'   => 'reactor.profile.update']);
            Route::get('password', [
                'uses' => 'ProfileController@password',
                'as'   => 'reactor.profile.password']);
            Route::put('password', [
                'uses' => 'ProfileController@updatePassword',
                'as'   => 'reactor.profile.password.post']);
            Route::get('history', [
                'uses' => 'ProfileController@history',
                'as'   => 'reactor.profile.history']);
        });

        // Content
        Route::group(['middleware' => 'guard:ACCESS_CONTENTS'], function ()
        {
            Route::get('contents/create/{id?}', [
                'uses' => 'NodesController@create',
                'as'   => 'reactor.contents.create']);
            Route::post('contents/create/{id?}', [
                'uses' => 'NodesController@store',
                'as'   => 'reactor.contents.store']);

            Route::get('contents/{id}/edit/{source?}', [
                'uses' => 'NodesController@edit',
                'as' => 'reactor.contents.edit'
            ]);
            Route::put('contents/{id}/edit/{source?}', [
                'uses' => 'NodesController@update',
                'as' => 'reactor.contents.update'
            ]);

            Route::delete('contents/{id}', [
                'uses' => 'NodesController@destroy',
                'as' => 'reactor.contents.destroy'
            ]);

            Route::get('contents/{id}/seo/{source?}', [
                'uses' => 'NodesController@seo',
                'as'   => 'reactor.contents.seo']);
            Route::put('contents/{id}/seo/{source?}', [
                'uses' => 'NodesController@updateSEO',
                'as'   => 'reactor.contents.seo.update']);

            Route::get('contents/{id}/parameters', [
                'uses' => 'NodesController@parameters',
                'as'   => 'reactor.contents.parameters']);
            Route::put('contents/{id}/parameters', [
                'uses' => 'NodesController@updateParameters',
                'as'   => 'reactor.contents.parameters.update']);

            Route::get('contents/{id}/translate', [
                'uses' => 'NodesController@createTranslation',
                'as'   => 'reactor.contents.translation.create']);
            Route::post('contents/{id}/translate', [
                'uses' => 'NodesController@storeTranslation',
                'as'   => 'reactor.contents.translation.store']);

            Route::get('contents/search', [
                'uses' => 'NodesController@search',
                'as'   => 'reactor.contents.search']);

            Route::post('contents/locale', [
                'uses' => 'NodesController@changeTreeLocale',
                'as' => 'reactor.contents.locale'
            ]);
        });

        // Nodes Types and Fields
        Route::group(['middleware' => 'guard:ACCESS_NODES'], function ()
        {
            Route::resource('nodes', 'NodeTypesController', ['except' => ['show'], 'names' => [
                'index'   => 'reactor.nodes.index',
                'create'   => 'reactor.nodes.create',
                'store'   => 'reactor.nodes.store',
                'edit'    => 'reactor.nodes.edit',
                'update'  => 'reactor.nodes.update',
                'destroy' => 'reactor.nodes.destroy',
            ]]);
            Route::get('nodes/search', [
                'uses' => 'NodeTypesController@search',
                'as'   => 'reactor.nodes.search']);
            Route::get('nodes/{id}/fields', [
                'uses' => 'NodeTypesController@fields',
                'as'   => 'reactor.nodes.fields']);

            // Node Fields
            Route::get('nodes/{id}/fields/create', [
                'uses' => 'NodeFieldsController@create',
                'as'   => 'reactor.nodes.field.create']);
            Route::post('nodes/{id}/fields', [
                'uses' => 'NodeFieldsController@store',
                'as'   => 'reactor.nodes.field.store']);
            Route::get('nodes/fields/{id}', [
                'uses' => 'NodeFieldsController@edit',
                'as'   => 'reactor.nodes.field.edit']);
            Route::put('nodes/fields/{id}', [
                'uses' => 'NodeFieldsController@update',
                'as'   => 'reactor.nodes.field.update']);
            Route::delete('nodes/fields/{id}', [
                'uses' => 'NodeFieldsController@destroy',
                'as'   => 'reactor.nodes.field.destroy']);
        });

        // Documents
        Route::group(['middleware' => 'guard:ACCESS_DOCUMENTS'], function ()
        {
            Route::resource('documents', 'DocumentsController', ['except' => ['show', 'create'], 'names' => [
                'index'   => 'reactor.documents.index',
                'store'   => 'reactor.documents.store',
                'edit'    => 'reactor.documents.edit',
                'update'  => 'reactor.documents.update',
                'destroy' => 'reactor.documents.destroy',
            ]]);
            Route::get('documents/search', [
                'uses' => 'DocumentsController@search',
                'as'   => 'reactor.documents.search']);
            Route::get('documents/upload', [
                'uses' => 'DocumentsController@upload',
                'as'   => 'reactor.documents.upload']);
            Route::get('documents/embed', [
                'uses' => 'DocumentsController@embed',
                'as'   => 'reactor.documents.embed']);
            Route::post('documents/embed', [
                'uses' => 'DocumentsController@storeEmbedded',
                'as'   => 'reactor.documents.embed.store']);
            Route::get('documents/image/{id}/edit', [
                'uses' => 'DocumentsController@image',
                'as'   => 'reactor.documents.image']);
            Route::put('documents/image/{id}', [
                'uses' => 'DocumentsController@imageUpdate',
                'as'   => 'reactor.documents.image.update']);
        });

        // Users
        Route::group(['middleware' => 'guard:ACCESS_USERS'], function ()
        {
            Route::resource('users', 'UsersController', ['except' => 'show', 'names' => [
                'index'   => 'reactor.users.index',
                'create'  => 'reactor.users.create',
                'store'   => 'reactor.users.store',
                'edit'    => 'reactor.users.edit',
                'update'  => 'reactor.users.update',
                'destroy' => 'reactor.users.destroy',
            ]]);
            Route::get('users/search', [
                'uses' => 'UsersController@search',
                'as'   => 'reactor.users.search']);

            Route::group(['middleware' => 'guard:ACCESS_ROLES_EDIT'], function ()
            {
                Route::get('users/{id}/password', [
                    'uses' => 'UsersController@password',
                    'as'   => 'reactor.users.password']);
                Route::put('users/{id}/password', [
                    'uses' => 'UsersController@updatePassword',
                    'as'   => 'reactor.users.password.post']);
                Route::get('users/{id}/permissions', [
                    'uses' => 'UsersController@permissions',
                    'as'   => 'reactor.users.permissions']);
                Route::put('users/{id}/permissions', [
                    'uses' => 'UsersController@addPermission',
                    'as'   => 'reactor.users.permission.add']);
                Route::delete('users/{id}/permissions', [
                    'uses' => 'UsersController@removePermission',
                    'as'   => 'reactor.users.permission.remove']);
                Route::get('users/{id}/roles', [
                    'uses' => 'UsersController@roles',
                    'as'   => 'reactor.users.roles']);
                Route::put('users/{id}/roles', [
                    'uses' => 'UsersController@addRole',
                    'as'   => 'reactor.users.role.add']);
                Route::delete('users/{id}/roles', [
                    'uses' => 'UsersController@removeRole',
                    'as'   => 'reactor.users.role.remove']);
                Route::get('users/{id}/history', [
                    'uses' => 'UsersController@history',
                    'as'   => 'reactor.users.history']);
            });
        });

        // Roles
        Route::group(['middleware' => 'guard:ACCESS_ROLES'], function ()
        {
            Route::resource('roles', 'RolesController', ['except' => 'show', 'names' => [
                'index'   => 'reactor.roles.index',
                'create'  => 'reactor.roles.create',
                'store'   => 'reactor.roles.store',
                'edit'    => 'reactor.roles.edit',
                'update'  => 'reactor.roles.update',
                'destroy' => 'reactor.roles.destroy',
            ]]);
            Route::get('roles/search', [
                'uses' => 'RolesController@search',
                'as'   => 'reactor.roles.search']);

            Route::group(['middleware' => 'guard:ACCESS_ROLES_EDIT'], function ()
            {
                Route::get('roles/{id}/permissions', [
                    'uses' => 'RolesController@permissions',
                    'as'   => 'reactor.roles.permissions']);
                Route::put('roles/{id}/permissions', [
                    'uses' => 'RolesController@addPermission',
                    'as'   => 'reactor.roles.permission.add']);
                Route::delete('roles/{id}/permissions', [
                    'uses' => 'RolesController@removePermission',
                    'as'   => 'reactor.roles.permission.remove']);
                Route::get('roles/{id}/users', [
                    'uses' => 'RolesController@users',
                    'as'   => 'reactor.roles.users']);
                Route::put('roles/{id}/users', [
                    'uses' => 'RolesController@addUser',
                    'as'   => 'reactor.roles.user.add']);
                Route::delete('roles/{id}/users', [
                    'uses' => 'RolesController@removeUser',
                    'as'   => 'reactor.roles.user.remove']);
            });
        });

        // Permissions
        Route::group(['middleware' => 'guard:ACCESS_PERMISSIONS'], function ()
        {
            Route::resource('permissions', 'PermissionsController', ['except' => 'show', 'names' => [
                'index'   => 'reactor.permissions.index',
                'create'  => 'reactor.permissions.create',
                'store'   => 'reactor.permissions.store',
                'edit'    => 'reactor.permissions.edit',
                'update'  => 'reactor.permissions.update',
                'destroy' => 'reactor.permissions.destroy',
            ]]);
            Route::get('permissions/search', [
                'uses' => 'PermissionsController@search',
                'as'   => 'reactor.permissions.search']);
        });

        // Settings
        Route::group(['middleware' => 'guard:ACCESS_SETTINGS'], function ()
        {
            Route::resource('settings', 'SettingsController', ['except' => 'show', 'names' => [
                'index'   => 'reactor.settings.index',
                'create'  => 'reactor.settings.create',
                'store'   => 'reactor.settings.store',
                'edit'    => 'reactor.settings.edit',
                'update'  => 'reactor.settings.update',
                'destroy' => 'reactor.settings.destroy',
            ]]);
            Route::get('settings/group/{group?}', [
                'uses' => 'SettingsController@editSettings',
                'as'   => 'reactor.settings.group.edit']);
            Route::put('settings/group/{group}', [
                'uses' => 'SettingsController@updateSettings',
                'as'   => 'reactor.settings.group.update']);
        });

        // Setting groups
        Route::group(['middleware' => 'guard:ACCESS_SETTINGGROUPS'], function ()
        {
            Route::resource('setting-groups', 'SettingGroupsController', ['except' => 'show', 'names' => [
                'index'   => 'reactor.settinggroups.index',
                'create'  => 'reactor.settinggroups.create',
                'store'   => 'reactor.settinggroups.store',
                'edit'    => 'reactor.settinggroups.edit',
                'update'  => 'reactor.settinggroups.update',
                'destroy' => 'reactor.settinggroups.destroy',
            ]]);
        });

    });

});
