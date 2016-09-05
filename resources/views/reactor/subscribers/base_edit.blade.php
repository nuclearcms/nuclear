@extends('layout.' . ((isset($_withForm) && $_withForm === true) ? 'form' : 'content'))

@section('pageSubtitle')
    {!! link_to_route('reactor.subscribers.index', uppercase(trans('subscribers.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $subscriber->email,
        'headerHint' => $subscriber->name
    ])
@endsection