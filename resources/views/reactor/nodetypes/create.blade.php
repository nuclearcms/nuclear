@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.nodetypes.index', uppercase(trans('nodetypes.title'))) !!}
@endsection

@section('content')
    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection

@section('form_buttons')
    {!! submit_button('icon-plus') !!}
@endsection