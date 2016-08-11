@extends('layout.base')

@section('pageTitle', $pageTitle)

@section('body')
    <main class="container-main" id="mainContainer">

        @include('partials.navigation')

        <a href="#" id="hamburger" class="hamburger exclude-ui-events">
            <i class="icon-hamburger icon-list-bullet"></i>
        </a>

        <div class="container-content" id="contentContainer">

            <div id="contentWhiteout" class="content-whiteout"></div>

            <div class="content" id="content">
                @yield('form_start')

                <header class="header">

                    <hgroup class="header__headings">
                        <h3 class="header__subheading">@yield('pageSubtitle')</h3>
                        <h1 class="header__heading">@yield('pageTitle')</h1>
                    </hgroup>

                    <div class="header__actions">
                        @yield('actions')
                    </div>

                </header>

                @yield('content')

                @yield('form_end')
            </div>

        </div>
    </main>
@endsection