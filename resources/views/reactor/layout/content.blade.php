@extends('layout.reactor')

@section('content')

    <div class="content-options">
        @yield('content_options')
    </div>

    <div class="content-list-container material-light">
        <table class="content-list">
            <thead class="content-header">
                <tr>
                    <th></th>

                    @yield('content_sortable_links')

                    <th></th>
                </tr>
            </thead>
            <tbody class="content-body">

                @yield('content_list')

            </tbody>
        </table>

        <div class="content-footer">
            @yield('content_footer')
        </div>

    </div>

@endsection