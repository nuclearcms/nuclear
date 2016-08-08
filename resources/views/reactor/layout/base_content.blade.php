@yield('form_start')

<header class="header">

    <hgroup class="header__headings">
        <h3>@yield('contentSubtitle')</h3>
        <h1>@yield('pageTitle')</h1>
    </hgroup>

    <div class="header__actions">
        @yield('actions')
    </div>

</header>

@yield('content')

@yield('form_end')