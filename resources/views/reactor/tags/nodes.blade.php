@extends('tags.base_edit')
<?php $_withForm = false; ?>

@section('content')
    @include('tags.tabs', [
        'currentRoute' => 'reactor.tags.nodes',
        'currentKey' => [$tag->getKey(), $translation->getKey()]
    ])

    <div class="content-inner content-inner--xcompact">
        @include('nodes.sublist', ['locale' => null])
    </div>
@endsection