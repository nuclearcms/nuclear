@extends('layout.' . ((isset($_withForm) && $_withForm === true) ? 'form' : 'content'))

@section('pageSubtitle')
    {!! link_to_route('reactor.mailing_lists.index', uppercase(trans('mailing_lists.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $mailing_list->name
    ])
@endsection