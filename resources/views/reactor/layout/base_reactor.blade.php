@extends('layout.base')

@section('body')
    <main class="container-main" id="mainContainer">

        @include('partials.navigation')

        <div class="container-content" id="contentContainer">
            @include('layout.base_content')
        </div>
    </main>
@endsection