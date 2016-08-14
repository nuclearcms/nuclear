@extends('layout.' . ((isset($_withForm) && $_withForm === false) ? 'content' : 'form'))

@section('pageSubtitle', uppercase(trans('users.profile')))

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