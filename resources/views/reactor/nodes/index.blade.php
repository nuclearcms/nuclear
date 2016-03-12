@extends('layout.reactor')

@section('pageTitle', trans('nodes.' . $scope . '_nodes'))
@section('contentSubtitle', uppercase(trans('nodes.title')))

@section('content')
    <div class="material-light">
        @include('nodes.translationtabs_index')

        @include('nodes.subtable')
    </div>
@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete'])