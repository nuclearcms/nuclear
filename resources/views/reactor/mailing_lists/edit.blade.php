@extends('mailing_lists.base_edit')
<?php $_withForm = true; ?>

@section('form_buttons')
    @can('EDIT_MAILINGLISTS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection

@section('content')
    @include('mailing_lists.tabs', [
        'currentRoute' => 'reactor.mailing_lists.edit',
        'currentKey' => $mailing_list->getKey()
    ])

    @include('partials.contents.form')
@endsection