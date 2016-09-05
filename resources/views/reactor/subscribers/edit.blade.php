@extends('subscribers.base_edit')
<?php $_withForm = true; ?>

@section('form_buttons')
    @can('EDIT_SUBSCRIBERS')
        {!! submit_button('icon-floppy') !!}
    @endcan
@endsection

@section('content')
    @include('subscribers.tabs', [
        'currentRoute' => 'reactor.subscribers.edit',
        'currentKey' => $subscriber->getKey()
    ])

    @include('partials.contents.form')
@endsection