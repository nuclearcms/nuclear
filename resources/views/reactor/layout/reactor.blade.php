@extends('layout.base')

@section('pageTitle', $pageTitle)

@section('body')
    <main class="container-main" id="mainContainer">

        @include('partials.navigation')

        <a href="#" id="hamburger" class="hamburger exclude-ui-events">
            <i class="icon-hamburger"></i>
        </a>

        <div class="container-content" id="contentContainer">
            <div class="container-content__inner">
                <div id="contentWhiteout" class="content-whiteout"></div>

                <div class="content" id="content">

                    @include('partials.flash')

                    <header class="header">

                        <hgroup class="header__headings">
                            <h3 class="header__subheading">@yield('pageSubtitle')</h3>
                            <h1 class="header__heading">@yield('pageTitle')</h1>
                        </hgroup>

                        @yield('header_content')

                        <div class="header__actions">
                            @yield('actions')
                        </div>

                    </header>

                    @yield('content')
                </div>
            </div>

        </div>
    </main>
@endsection

@include('partials.modals.delete')