@extends('layout.reactor')

@section('pageTitle', trans('documents.edit_image'))
@section('contentSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('action')
    {!! action_button(route('reactor.documents.edit', $media->getKey()), 'icon-reply') !!}
@endsection

@section('content')
    @include('partials.content.header', [
        'headerTitle' => $media->name,
        'headerHint' => $media->present()->tag
    ])

    <ul class="document-image-options">
        <li>
            <button id="crop" class="button">
                <i class="icon-crop"></i>
            </button>
        </li>
        <li>
            <button id="rotate-left" class="button">
                <i class="icon-ccw"></i>
            </button>
        </li>
        <li>
            <button id="rotate-right" class="button">
                <i class="icon-cw"></i>
            </button>
        </li>
        <li>
            <button id="flip-horizontal" class="button">
                <i class="icon-resize-horizontal"></i>
            </button>
        </li>
        <li>
            <button id="flip-vertical" class="button">
                <i class="icon-resize-vertical"></i>
            </button>
        </li>
    </ul>

    <div class="document-edit-container">
        <div class="document-edit-image">
            <img src="{{ $media->getPublicURL() }}" class="image-editable">
            <div class="document-crop-frame"></div>
        </div>
    </div>

@endsection

@section('scripts')
    {!! Theme::js('js/image.js') !!}
@endsection