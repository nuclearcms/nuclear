@extends('layout.form')

@section('pageSubtitle')
    {!! link_to_route('reactor.tags.edit', uppercase($translation->title), [$tag->getKey(), $translation->getKey()]) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $tag->title,
        'headerHint' => $tag->tag_name
    ])
@endsection

@section('content')
    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_rest($form) !!}
        </div>
    </div>
@endsection

@section('form_buttons')
    {!! submit_button('icon-language') !!}
@endsection