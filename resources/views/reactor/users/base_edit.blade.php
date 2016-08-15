@extends('layout.' . ((isset($_withForm) && $_withForm === false) ? 'content' : 'form'))

@section('pageSubtitle')
    {!! link_to_route('reactor.users.index', uppercase(trans('users.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $profile->present()->fullName
    ])
@endsection

@section('content')
    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection