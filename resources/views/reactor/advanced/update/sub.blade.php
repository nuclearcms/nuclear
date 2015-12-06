<section class="advanced-options-set">
    <h3 class="icon-cancel warning">{{ trans('advanced.not_up_to_date') }}</h3>

    <p class="advanced-option-description">
        {!! trans('advanced.not_up_to_date_description', [
            'version' => nuclear_version(),
            'current' => $latest->tag_name
        ]) !!}
    </p>
</section>

<section class="advanced-options-set">
    <h3 class="icon-newspaper">{{ trans('advanced.changelog') }}</h3>

    <h4>{{ $latest->name }}</h4>
    <div class="advanced-option-description markdown-body">
        {!! Synthesizer::HTMLmarkdown($latest->body) !!}
    </div>
</section>

<section class="advanced-options-set">
    <h3 class="icon-arrows-cw">{{ trans('advanced.auto_update') }}</h3>

    <p class="advanced-option-description warn">
        {!! trans('advanced.auto_update_description') !!}
    </p>

    <div class="form-group inline">
        {!! action_button(route('reactor.advanced.update.start'), 'icon-arrows-cw', false, trans('advanced.update_nuclear')) !!}
    </div>
</section>