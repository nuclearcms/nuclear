@extends('layout.base')

@section('body')
    <div class="container-main">

        @include('partials.navigation')

        <div class="container">
            @yield('content')
        </div>

        @include('partials.footer')

    </div>
@endsection