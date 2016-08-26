@extends('layout.reactor')

@section('scripts')
    @parent

    <script>window.locale = '{{ app()->getLocale() }}';</script>
    {!! Theme::js('js/forms.js') !!}
    {{-- EXTEND THESE WITH TAGS SCRIPT ON NODES FORM EXTENSION WITH @parent --}}
@endsection

@section('modules')
    @parent

    {{-- THESE ONLY SHOULD BE ON NODES FORM BASE
    @include('documents.modal')
    @include('modal.editor', ['containerClass' => 'modal--editor'])
    --}}
@endsection