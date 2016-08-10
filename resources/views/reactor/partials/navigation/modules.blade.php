<div class="navigation-column navigation-column--modules">

    <div class="scroller scroller--navigation-modules">
        <ul class="navigation-modules">

            <li class="navigation-module has-dropdown" data-hover="true">
                <a href="{{ route('reactor.dashboard') }}">
                    <i class="navigation-module__icon icon-dashboard"></i>
                </a>
            </li>

            {!! app('reactor.builders.navigation')->makeMainNavigation() !!}
            {!! app('reactor.builders.navigation')->makeFinalNavigation() !!}

            <li class="navigation-module navigation-user has-dropdown" data-hover="true">
            <span class="navigation-user__avatar">
                {!! $user->present()->avatar !!}
            </span>

                <div class="navigation-module__dropdown">
                    <div class="navigation-module__info">{{ uppercase($user->present()->fullName) }}</div>
                    <ul class="navigation-module-sub">
                        {!! navigation_module_link('reactor.profile.edit', 'icon-profile', 'users.update_profile') !!}
                        {!! navigation_module_link('reactor.profile.password', 'icon-lock', 'users.change_password') !!}
                        {!! navigation_module_link('reactor.auth.logout', 'icon-logout', 'auth.logout') !!}
                    </ul>
                </div>
            </li>

        </ul>
    </div>

    <div class="navigation-brand">
        <a href="https://github.com/NuclearCMS/nuclear" target="_blank" class="exclude-ui-events navigation-brand__nuclear">
            {!! Theme::img('img/nuclear-logo.svg') !!}
            <span>v{{ nuclear_version() }}</span>
        </a>
        <a href="http://kenarkose.com" target="_blank" class="exclude-ui-events navigation-brand__kk">
            <i class="icon-kk"></i>
        </a>
    </div>
</div>