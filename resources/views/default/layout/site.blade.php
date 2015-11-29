@extends('layout.base')

@section('body')
    <div class="container">
        <div class="content">
            <header class="header">
                <div class="title">@yield('pageTitle')</div>

                <nav class="navigation">
                    @include('partials.navigation')
                </nav>
            </header>

            <main class="content-wrapper">
                @yield('content')
            </main>

            <footer class="footer">
                @include('partials.footer')
            </footer>
        </div>
    </div>
@endsection