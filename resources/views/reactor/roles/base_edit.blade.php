@extends('layout.' . ((isset($_withForm) && $_withForm === false) ? 'content' : 'form'))

@section('pageSubtitle')
    {!! link_to_route('reactor.roles.index', uppercase(trans('roles.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => isset($role) ? $role->label : $model->label,
        'headerHint' => isset($role) ? $role->name : $model->name
    ])
@endsection

@section('content')
    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection