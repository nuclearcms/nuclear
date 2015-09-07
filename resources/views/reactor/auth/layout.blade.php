@extends('layout.base')

@section('body')
    <main class="container-fullscreen texture-overlay">
        <div class="auth-dialog dialog-static material-light">
            <div class="auth-logo">
                {!! Theme::img('img/nuclear-logo.svg', 'Nuclear Logo') !!}
            </div>

            @yield('content')

        </div>
    </main>
@endsection