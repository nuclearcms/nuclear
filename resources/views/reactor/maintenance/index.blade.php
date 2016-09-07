@extends('layout.reactor')

@section('pageSubtitle', uppercase(trans('maintenance.title')))

@section('content')
    <div class="content-inner">
        <div class="form-column form-column--full">
            <div class="content-inner__section">
                <h3 class="content-inner__heading">{{ trans('maintenance.optimization') }}</h3>
                <p class="content-inner__message content-inner__message--muted">{{ trans('maintenance.optimization_hint') }}</p>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.optimize') }}" type="button">
                    {{ uppercase(trans('maintenance.optimize_app')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.cache.routes') }}" type="button">
                    {{ uppercase(trans('maintenance.cache_routes')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.nodes.tree') }}" type="button">
                    {{ uppercase(trans('maintenance.fix_nodes_tree')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.key') }}" type="button">
                    {{ uppercase(trans('maintenance.regenerate_key')) }}
                </button>
            </div>

            <div class="content-inner__section">
                <h3 class="content-inner__heading">{{ trans('maintenance.backup') }}</h3>
                <p class="content-inner__message content-inner__message--muted">{{ trans('maintenance.backup_hint') }}</p>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.backup.create') }}" type="button">
                    {{ uppercase(trans('maintenance.create_backup')) }}
                </button>
            </div>

            <div class="content-inner__section">
                <h3 class="content-inner__heading">{{ trans('maintenance.cleanup') }}</h3>
                <p class="content-inner__message content-inner__message--muted">{{ trans('maintenance.cleanup_hint') }}</p>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.views') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_views')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.cache') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_cache')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.password') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_password_resets')) }}
                </button>
            </div>

            <div class="content-inner__section">
                <h3 class="content-inner__heading">{{ trans('maintenance.statistics') }}</h3>
                <p class="content-inner__message content-inner__message--muted">{{ trans('maintenance.statistics_hint') }}</p>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.statistics') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_tracker_all')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.statistics.year') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_tracker_older_year')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.statistics.month') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_tracker_older_month')) }}
                </button>
            </div>

            <div>
                <h3 class="content-inner__heading">{{ trans('maintenance.activity_feed') }}</h3>
                <p class="content-inner__message content-inner__message--muted">{{ trans('maintenance.activity_feed_hint') }}</p>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.activities') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_activities_all')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.activities.year') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_activities_older_year')) }}
                </button>

                <button class="button button--emphasis button--maintenance"
                        data-action="{{ route('reactor.maintenance.clear.activities.month') }}" type="button">
                    {{ uppercase(trans('maintenance.clear_activities_older_month')) }}
                </button>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var advancedButtons = $('button.button--maintenance');

            advancedButtons.click(function(e) {
                var action = $(this).data('action'),
                    form = $('<form/>')
                        .attr('action', action)
                        .attr('method', 'POST');

                $('{{ csrf_field() }}').appendTo(form);

                form.appendTo('body').submit().remove();

                e.preventDefault();
                e.stopPropagation();
            });
        });
    </script>
@endsection