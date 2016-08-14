@extends('profile.base_edit')

@section('content')
    @include('profile.tabs', [
        'currentRoute' => 'reactor.profile.password',
        'currentKey' => []
    ])
    @parent
@endsection

@section('form_buttons')
    {!! submit_button('icon-lock') !!}
@endsection