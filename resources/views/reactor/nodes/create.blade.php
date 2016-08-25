@extends('layout.form')

@section('pageSubtitle')
    {!! ($parent)
    ? link_to($parent->getDefaultEditUrl(), uppercase($parent->getTitle()))
    : uppercase(trans('nodes.title')) !!}
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