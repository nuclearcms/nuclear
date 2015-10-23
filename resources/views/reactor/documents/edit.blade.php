@extends('layout.form')

@section('pageTitle', trans('documents.edit'))
@section('contentSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('action')
    {!! submit_button('icon-floppy') !!}
    @if($media->isImage())
        {!! action_button(route('reactor.documents.image', $media->getKey()), 'icon-picture', true) !!}
    @endif
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $media->name,
        'headerHint' => $media->present()->tag
    ])

    {!! $media->present()->preview !!}

    <div class="content-form material-light">
        {!! form_rest($form) !!}
    </div>

@endsection