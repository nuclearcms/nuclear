{!! form_start($form) !!}

<div class="content-inner">
    <div class="form-column form-column--full">
        {!! form_rest($form) !!}
    </div>
    <div class="form-buttons" id="formButtons">
        @yield('form_buttons')
    </div>
</div>

{!! form_end($form) !!}