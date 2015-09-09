<div id="navigation" class="container-navigation">
    <nav id="nav_modules" class="navigation-tab navigation-modules">
        <ul class="navigation-modules-list">

            <li class="navigation-module">
                <a href="/reactor">
                    <i class="icon-gauge"></i>
                    <div class="module-dropdown module-dropdown-hidden">
                        <div class="module-info">{{ uppercase(trans('general.dashboard')) }}</div>
                    </div>
                </a>
            </li>

            <li class="navigation-module">
                <i class="icon-flow-cascade"></i>
                <div class="module-dropdown material-light">
                    <div class="module-info">
                        {{ uppercase(trans('nodes.management')) }}
                    </div>
                    <ul class="module-sub">

                    </ul>
                </div>
            </li>

            <li class="navigation-module">
                <i class="icon-docs"></i>
                <div class="module-dropdown material-light">
                    <div class="module-info">
                        {{ uppercase(trans('documents.title')) }}
                    </div>
                    <ul class="module-sub">
                        <li>
                            <a href="/reactor/documents"><i class="icon-folder-empty"></i>{{ trans('documents.manage') }}</a>
                        </li>
                        <li>
                            <a href="/reactor/documents/upload"><i class="icon-upload-cloud"></i>{{ trans('documents.upload') }}</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="navigation-module">
                <i class="icon-user"></i>
                <div class="module-dropdown material-light">
                    <div class="module-info">
                        {{ uppercase(trans('users.title')) }}
                    </div>
                    <ul class="module-sub">
                        <li>
                            <a href="/reactor/users"><i class="icon-user"></i>{{ trans('users.manage') }}</a>
                        </li>
                        <li>
                            <a href="/reactor/users/groups"><i class="icon-users"></i>{{ trans('users.manage_groups') }}</a>
                        </li>
                        <li>
                            <a href="/reactor/users/roles"><i class="icon-list-add"></i>{{ trans('users.manage_roles') }}</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="navigation-module">
                <i class="icon-cog"></i>
                <div class="module-dropdown material-light">
                    <div class="module-info">
                        {{ uppercase(trans('settings.title')) }}
                    </div>
                    <ul class="module-sub">
                        <li>
                            <a href="/reactor/settings"><i class="icon-list"></i>{{ trans('settings.all') }}</a>
                        </li>
                        <li>
                            <a href="/reactor/settings"><i class="icon-list"></i>NEED TO LIST GROUPS</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="navigation-module navigation-user">
                <span class="navigation-user-frame">
                    {!! $user->present()->avatar !!}
                </span>
                <div class="module-dropdown material-light">
                    <div class="module-info">{{ uppercase($user->present()->fullName) }}</div>
                    <ul class="module-sub">
                        <li>
                            <a href="/reactor/users/{{ $user->getKey() }}/edit"><i class="icon-newspaper"></i>{{ trans('auth.edit_profile') }}</a>
                        </li>
                        <li>
                            <a href="/reactor/auth/logout"><i class="icon-logout"></i>{{ trans('auth.logout') }}</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="navigation-version">
                <a href="/reactor/nuclear">
                    {!! Theme::img('img/nuclear-logo.svg', 'Nuclear Logo') !!}
                    <span>v{{ nuclear_version() }}</span>
                </a>
            </li>

        </ul>
    </nav><nav id="nav_nodes" class="navigation-tab navigation-nodes">
        @include('partials.nodes')
    </nav>
</div>