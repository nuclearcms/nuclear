<div id="navigation" class="container-navigation">

    <ul class="navigation-tabs">
        <li data-for="modules" class="active">
            <i class="icon-ellipsis-vert"></i>
        </li>
        <li data-for="nodes">
            <i class="icon-flow-cascade"></i>
        </li>
    </ul>

    <button id="nav_close" class="navigation-close">
        <i class="icon-cancel"></i>
    </button>

    <nav id="nav_modules" class="navigation-tab navigation-modules active">
        <div class="scroll-container">
            <div class="scroller">
                <ul class="navigation-modules-list">

                    <li class="navigation-module module-hidden-collapse">
                        <a href="{{ route('reactor.dashboard') }}">
                            <i class="icon-gauge"></i>
                        </a>
                    </li>

                    <li class="navigation-module module-hidden">
                        <div class="module-dropdown">
                            <ul class="module-sub">
                                {!! navigation_module_link('reactor.dashboard', 'icon-gauge', 'general.dashboard') !!}
                            </ul>
                        </div>
                    </li>

                    @can('ACCESS_NODES')
                    {!! navigation_module_open('icon-flow-cascade', 'nodes.management') !!}

                    {!! navigation_module_close() !!}
                    @endcan

                    @can('ACCESS_DOCUMENTS')
                    {!! navigation_module_open('icon-docs', 'documents.title') !!}
                        {!! navigation_module_link('reactor.dashboard', 'icon-folder-empty', 'documents.manage') !!}

                        @can('ACCESS_DOCUMENTS_UPLOAD')
                        {!! navigation_module_link('reactor.dashboard', 'icon-upload-cloud', 'documents.upload') !!}
                        @endcan
                    {!! navigation_module_close() !!}
                    @endcan

                    @can('ACCESS_USERS')
                    {!! navigation_module_open('icon-user', 'users.title') !!}
                        {!! navigation_module_link('reactor.users.index', 'icon-user', 'users.manage') !!}

                        @can('ACCESS_ROLES')
                        {!! navigation_module_link('reactor.roles.index', 'icon-users', 'users.manage_roles') !!}
                        @endcan

                        @can('ACCESS_PERMISSIONS')
                        {!! navigation_module_link('reactor.permissions.index', 'icon-list', 'users.manage_permissions') !!}
                        @endcan
                    {!! navigation_module_close() !!}
                    @endcan

                    @can('ACCESS_SETTINGS')
                    {!! navigation_module_open('icon-cog', 'settings.title') !!}
                        {!! navigation_module_link('reactor.settings.index', 'icon-cog', 'settings.manage') !!}

                        @can('ACCESS_SETTINGGROUPS')
                        {!! navigation_module_link('reactor.settinggroups.index', 'icon-list', 'settings.manage_groups') !!}
                        @endcan

                        @can('ACCESS_SETTINGS_MODIFY')
                        {!! navigation_module_link('reactor.settings.group.edit', 'icon-blank', 'settings.all', []) !!}

                        @foreach(settings()->getGroups() as $key => $group)
                            {!! navigation_module_link('reactor.settings.group.edit', 'icon-blank', $group, $key) !!}
                        @endforeach

                        @endcan
                    {!! navigation_module_close() !!}
                    @endcan

                    <li class="navigation-module navigation-user">
                        <span class="user-frame">
                            {!! $user->present()->avatar !!}
                        </span>

                        <div class="module-dropdown material-middle">
                            <div class="module-info">{{ uppercase($user->present()->fullName) }}</div>
                            <ul class="module-sub">
                                {!! navigation_module_link('reactor.profile.edit', 'icon-newspaper', 'auth.edit_profile') !!}
                                {!! navigation_module_link('reactor.auth.logout', 'icon-logout', 'auth.logout') !!}
                            </ul>
                        </div>
                    </li>

                    <li class="navigation-module navigation-version module-hidden-collapse">
                        <a href="#">
                            {!! Theme::img('img/nuclear-logo.svg', 'Nuclear Logo') !!}
                            <span>v{{ nuclear_version() }}</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav><nav id="nav_nodes" class="navigation-tab navigation-nodes">
        @include('partials.nodes')
    </nav>
</div>
<div id="blackout" class="blackout"></div>
<button id="hamburger" class="hamburger">
    <i class="icon-menu"></i>
</button>