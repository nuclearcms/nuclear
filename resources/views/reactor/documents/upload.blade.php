@extends('layout.reactor')

@section('pageTitle', trans('documents.upload'))
@section('contentSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('content')

    @include('documents.dropzone')

@endsection

@section('scripts')
    {!! Theme::js('js/upload.js') !!}
    <script>
        var uploader = new Uploader($('#dropzone'));
    </script>
@endsection