@extends('layout.base')

@section('body')
    <main class="container container-main">

        @include('partials.navigation')

        <div class="container-content">
            <header class="header">
                <h3>@yield('contentSubtitle')</h3>
                <h1>@yield('pageTitle')</h1>

                <div class="header-action material-light">
                    @yield('action')
                </div>
            </header>

            @yield('content')

        </div>

    </main>
@endsection