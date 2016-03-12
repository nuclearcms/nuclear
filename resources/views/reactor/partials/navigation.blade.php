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

                    @can('ACCESS_CONTENTS')
                    {!! navigation_module_open('icon-flow-tree', 'nodes.title') !!}
                        {!! navigation_module_link('reactor.contents.index', 'icon-cancel-circled', 'nodes.not-published_nodes', ['not-published']) !!}
                        {!! navigation_module_link('reactor.contents.index', 'icon-lock', 'nodes.locked_nodes', ['locked']) !!}
                        {!! navigation_module_link('reactor.contents.index', 'icon-eye-off', 'nodes.invisible_nodes', ['invisible']) !!}
                        <li class="options-splitter"></li>
                        {!! navigation_module_link('reactor.contents.index', 'icon-ok-circled', 'nodes.published_nodes', ['published']) !!}
                        {!! navigation_module_link('reactor.contents.index', 'icon-circle-empty', 'nodes.draft_nodes', ['draft']) !!}
                        {!! navigation_module_link('reactor.contents.index', 'icon-clock', 'nodes.pending_nodes', ['pending']) !!}
                        {!! navigation_module_link('reactor.contents.index', 'icon-dot-circled', 'nodes.archived_nodes', ['archived']) !!}
                    {!! navigation_module_close() !!}
                    @endcan

                    @can('ACCESS_TAGS')
                    {!! navigation_module_open('icon-tags', 'tags.title') !!}
                        {!! navigation_module_link('reactor.tags.index', 'icon-tag', 'tags.manage') !!}
                    {!! navigation_module_close() !!}
                    @endcan

                    @can('ACCESS_DOCUMENTS')
                    {!! navigation_module_open('icon-docs', 'documents.title') !!}
                        {!! navigation_module_link('reactor.documents.index', 'icon-folder-empty', 'documents.manage') !!}

                        @can('ACCESS_DOCUMENTS_UPLOAD')
                        {!! navigation_module_link('reactor.documents.upload', 'icon-upload-cloud', 'documents.upload') !!}
                        {!! navigation_module_link('reactor.documents.embed', 'icon-code', 'documents.embed') !!}
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

                    @can('ACCESS_NODES')
                    {!! navigation_module_open('icon-flow-cascade', 'nodes.management') !!}
                        {!! navigation_module_link('reactor.nodes.index', 'icon-flow-parallel', 'nodes.manage') !!}
                    {!! navigation_module_close() !!}
                    @endcan

                    @can('ACCESS_SETTINGS')
                    {!! navigation_module_open('icon-cog', 'settings.title') !!}
                        @can('ACCESS_SETTINGS_MODIFY')
                            {!! navigation_module_link('reactor.settings.group.edit', 'icon-cog-alt', 'settings.all', []) !!}
                        @endcan

                        @foreach(settings()->getGroups() as $key => $group)
                            {!! navigation_module_link('reactor.settings.group.edit', 'icon-blank', $group, $key) !!}
                        @endforeach

                        {!! navigation_module_link('reactor.settings.index', 'icon-tools', 'settings.manage') !!}

                        @can('ACCESS_SETTINGGROUPS')
                            {!! navigation_module_link('reactor.settinggroups.index', 'icon-list', 'settings.manage_groups') !!}
                        @endcan
                    {!! navigation_module_close() !!}
                    @endcan

                    @can('ACCESS_ADVANCED')
                    {!! navigation_module_open('icon-cog-alt', 'advanced.title') !!}
                        {!! navigation_module_link('reactor.advanced', 'icon-wrench', 'advanced.manage') !!}

                        {!! navigation_module_link('reactor.advanced.update', 'icon-arrows-cw', 'advanced.update') !!}
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
                        <a href="https://github.com/NuclearCMS/Nuclear" target="_blank">
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