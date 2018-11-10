<div class="navigation-column navigation-column--modules">

    <div class="scroller scroller--navigation-modules">
        <ul class="navigation-modules">

            <li class="navigation-module has-dropdown" data-hover="true">
                <a href="{{ route('reactor.dashboard') }}">
                    <i class="navigation-module__icon dropdown-icon icon-dashboard"></i>
                </a>
            </li>

            {!! app('reactor.builders.navigation')->makeMainNavigation() !!}
            {!! app('reactor.builders.navigation')->makeFinalNavigation() !!}

            <li class="navigation-module navigation-user has-dropdown" data-hover="true">
                <span class="navigation-user__avatar">
                    {!! $currentUser->present()->avatar !!}
                </span>

                <div class="dropdown navigation-module__dropdown">
                    <div class="dropdown__info navigation-module__info">{{ uppercase($currentUser->present()->fullName) }}</div>
                    <ul class="dropdown-sub navigation-module-sub">
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
        <a href="http://umomega.com" target="_blank" class="exclude-ui-events navigation-brand__kk">
            <svg style="height:14px;width:14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14"><defs><style>.cls-1{fill:#4a4f55;}</style></defs><title>umomega</title><path class="cls-1" d="M1.7,14.87H5.48V13.59a6.2,6.2,0,0,1-3.65-2.17,6.38,6.38,0,0,1-1.27-4A6.81,6.81,0,0,1,2.83,2,7.59,7.59,0,0,1,8,0a7.76,7.76,0,0,1,3.74,1,6.73,6.73,0,0,1,2.71,2.71,7.58,7.58,0,0,1,1,3.73,6.19,6.19,0,0,1-1.24,3.92,6.83,6.83,0,0,1-3.73,2.28v1.28h3.78V14.2a1.44,1.44,0,0,1,.14-.81.56.56,0,0,1,.43-.17.54.54,0,0,1,.31.09.47.47,0,0,1,.18.22,2.09,2.09,0,0,1,0,.67V16h-6V12.71a6,6,0,0,0,3.71-1.85,5.3,5.3,0,0,0,1.27-3.64,5.6,5.6,0,0,0-2-4.55A6.51,6.51,0,0,0,4,2.43,5.81,5.81,0,0,0,1.69,7.3,5.35,5.35,0,0,0,3,11a5.66,5.66,0,0,0,3.61,1.68V16H.63V14.2a2.81,2.81,0,0,1,0-.66.45.45,0,0,1,.19-.24.49.49,0,0,1,.3-.1.46.46,0,0,1,.27.08.63.63,0,0,1,.22.25,2.88,2.88,0,0,1,.05.67Z"/></svg>
        </a>
    </div>
</div>
