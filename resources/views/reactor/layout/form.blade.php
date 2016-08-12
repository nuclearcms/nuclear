@extends('layout.reactor')

@section('form_start', form_start($form))

@section('scripts')
    {!! Theme::js('js/forms.js') !!}
@endsection

@section('modules')
    {{--
    @include('documents.modal')
    @include('modal.editor', ['containerClass' => 'modal--editor'])
    --}}
@endsection

@section('form_end')

    <div class="form-buttons" id="formButtons">
        @yield('form_buttons')
    </div>

    {!! form_end($form) !!}
@endsection