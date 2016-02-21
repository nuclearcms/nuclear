@extends('layout.reactor')

@section('pageTitle', trans('advanced.manage'))
@section('contentSubtitle', uppercase(trans('advanced.title')))

@section('content')
    <div class="advanced-options content-form material-light">
        <section class="advanced-options-set">
            <h3 class="icon-cog">{{ trans('advanced.optimize') }}</h3>

            <p class="advanced-option-description">
                {!! trans('advanced.optimize_description') !!}
            </p>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.optimize_app'), ['class' => 'control-label']) !!}
                <button class="button button-emphasized button-secondary button-advanced-action"
                        data-action="{{ route('reactor.advanced.optimize') }}" type="button">
                    {{ uppercase(trans('advanced.optimize_app')) }}
                </button>
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.cache_routes'), ['class' => 'control-label']) !!}
                <button class="button button-emphasized button-secondary button-advanced-action"
                        data-action="{{ route('reactor.advanced.cache.routes') }}" type="button">
                    {{ uppercase(trans('advanced.cache_routes')) }}
                </button>
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.regenerate_key'), ['class' => 'control-label']) !!}
                <button class="button button-emphasized button-secondary button-advanced-action"
                        data-action="{{ route('reactor.advanced.key') }}" type="button">
                    {{ uppercase(trans('advanced.regenerate_key')) }}
                </button>
            </div>
        </section>
        <section class="advanced-options-set">
            <h3 class="icon-box">{{ trans('advanced.backup') }}</h3>

            <p class="advanced-option-description">
                {!! trans('advanced.backup_description') !!}
            </p>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.create_backup'), ['class' => 'control-label']) !!}
                <button class="button button-emphasized button-secondary button-advanced-action"
                        data-action="{{ route('reactor.advanced.backup.create') }}" type="button">
                    {{ uppercase(trans('advanced.create_backup')) }}
                </button>
            </div>

        </section>
        <section class="advanced-options-set">
            <h3 class="icon-trash">{{ trans('advanced.cleanup') }}</h3>

            <p class="advanced-option-description">
                {!! trans('advanced.cleanup_description') !!}
            </p>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.clear_password_resets'), ['class' => 'control-label']) !!}
                <button class="button button-emphasized button-secondary button-advanced-action"
                        data-action="{{ route('reactor.advanced.clear.password') }}" type="button">
                    {{ uppercase(trans('advanced.clear_password_resets')) }}
                </button>
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.clear_views'), ['class' => 'control-label']) !!}
                <button class="button button-emphasized button-secondary button-advanced-action"
                        data-action="{{ route('reactor.advanced.clear.views') }}" type="button">
                    {{ uppercase(trans('advanced.clear_views')) }}
                </button>
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.clear_activities'), ['class' => 'control-label']) !!}
                <button class="button button-emphasized button-secondary button-advanced-action"
                        data-action="{{ route('reactor.advanced.clear.activity') }}" type="button">
                    {{ uppercase(trans('advanced.clear_activities')) }}
                </button>
            </div>

            <div class="form-group inline">
                {!! Form::label('', trans('advanced.clear_cache'), ['class' => 'control-label']) !!}
                <button class="button button-emphasized button-secondary button-advanced-action"
                        data-action="{{ route('reactor.advanced.clear.cache') }}" type="button">
                    {{ uppercase(trans('advanced.clear_cache')) }}
                </button>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var advancedButtons = $('button.button-advanced-action');

            advancedButtons.click(function(e) {
                var action = $(this).data('action'),
                    form = $('<form/>')
                        .attr('action', action)
                        .attr('method', 'POST');

                $('<input type="hidden" name="_method" value="PUT">').appendTo(form);
                $('{{ csrf_field() }}').appendTo(form);

                form.appendTo('body').submit().remove();

                e.preventDefault();
                e.stopPropagation();
            });
        });
    </script>
@endsection