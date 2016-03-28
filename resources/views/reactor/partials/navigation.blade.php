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

                    {!! app('reactor.builders.navigation')->makeMainNavigation() !!}
                    {!! app('reactor.builders.navigation')->makeFinalNavigation() !!}

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
        @include('partials.reactor_nodes')
    </nav>
</div>
<div id="blackout" class="blackout"></div>
<button id="hamburger" class="hamburger">
    <i class="icon-menu"></i>
</button>