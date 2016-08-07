@extends('layout.base')

@section('body')
<main class="dialog-container dialog-container--small">
    <div class="dialog dialog--small">
        <div class="auth text--center">
            {!! Theme::img('img/nuclear-logo.svg', 'Nuclear Logo', 'dialog__logo') !!}

            <h1>@yield('pageTitle')</h1>

            @include('auth.error')

            @yield('content')
        </div>
    </div>
</main>
@endsection