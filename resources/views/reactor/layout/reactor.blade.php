@extends('layout.base')

@section('body')
    <main class="container container-main">

        @include('partials.navigation')

        <div class="container-content">

            @yield('form_start')

            <header class="header">

                <hgroup class="header-headings">
                    <h3>@yield('contentSubtitle')</h3>
                    <h1>@yield('pageTitle')</h1>
                </hgroup>

                <div class="header-action material-light">
                    @yield('action')
                </div>
                
            </header>

            @include('partials.flash')

            @yield('content')

            @yield('form_end')
        </div>

    </main>
@endsection