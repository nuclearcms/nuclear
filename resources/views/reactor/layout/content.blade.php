@extends('layout.reactor')

@section('content')

    <div class="content-options">
        @yield('content_options')
    </div>

    <div class="content-list-container material-light">

        {!! content_table_open() !!}

            @yield('content_sortable_links')

        {!! content_table_middle() !!}

            @yield('content_list')

        {!! content_table_close() !!}

        <div class="content-footer">
            @yield('content_footer')
        </div>

    </div>

@endsection