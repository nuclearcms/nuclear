@extends('profile.base_edit')

@section('form_buttons')
    {!! submit_button('icon-lock') !!}
@endsection

@section('content')
    @include('profile.tabs', [
        'currentRoute' => 'reactor.profile.password',
        'currentKey' => []
    ])
    @parent
@endsection