@extends('layout.' . ((isset($_withForm) && $_withForm === false) ? 'content' : 'form'))

@section('pageSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $document->name,
        'headerHint' => $document->present()->metaDescription
    ])
@endsection