@extends('profile.base_edit')

@section('content')
    @include('profile.tabs', [
        'currentRoute' => 'reactor.profile.edit',
        'currentKey' => []
    ])
    @parent
@endsection

@section('form_buttons')
    {!! submit_button('icon-floppy') !!}
@endsection