@extends('layout.base')

@section('body')
    <main class="container container-main">

        @include('partials.navigation')

        <div class="container-content">
            @yield('content')
        </div>

    </main>
@endsection