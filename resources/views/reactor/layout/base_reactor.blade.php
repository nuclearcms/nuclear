@extends('layout.base')

@section('body')
    <main class="container-main" id="mainContainer">

        @include('partials.navigation')

        <a href="#" id="hamburger" class="hamburger">
            <i class="icon-hamburger icon-list-bullet"></i>
        </a>

        <div class="container-content" id="contentContainer">

            <div id="contentWhiteout" class="content-whiteout"></div>

            <div class="content" id="content">
                @include('layout.base_content')
            </div>

        </div>
    </main>
@endsection