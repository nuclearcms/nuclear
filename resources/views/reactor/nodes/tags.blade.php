@extends('layout.reactor')

@section('pageTitle', trans('tags.title'))
@section('contentSubtitle', uppercase(trans('nodes.title')))

@section('content')
    @include('partials.nodes.ancestors', [
        'ancestors' => $node->getAncestors()
    ])

    @include('partials.content.header', [
        'headerTitle' => $source->title,
        'headerHint' => $node->nodeType->label
    ])

    <div class="material-light">
        @include('nodes.tabs', [
            'currentTab' => 'reactor.contents.tags',
            'currentKey' => $node->getKey()
        ])

        <div class="content-form content-form-narrow">
            <h3>{{ trans('nodes.edit_tags') }}</h3>

            <div class="form-group form-group-content form-group-tag"
                 data-urlunlink="{{ route('reactor.contents.tags.unlink', $node->getKey()) }}"
                 data-urladd="{{ route('reactor.contents.tags.add', $node->getKey()) }}"
                 data-urlsearch="{{ route('reactor.tags.search.json') }}">
                <div class="form-group-column form-group-column-field">
                    <label for="_tag" class="control-label">{{ trans('validation.attributes.tags') }}</label>

                    <div class="taglist-container">
                        <ul class="taglist {{ count($tags = $node->tags) ? '' : 'empty' }}">
                            @foreach($node->tags as $tag)
                                <li class="tag" data-id="{{ $tag->getKey() }}">
                                    <span>{{ $tag->name }}</span><i class="icon-cancel"></i>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tag-input form-items-search">
                            {!! Form::text('name', null, ['placeholder' => trans('hints.tags_placeholder'), 'autocomplete' => 'off']) !!}
                            <ul class="form-items-list form-items-list-results material-middle">

                            </ul>
                        </div>
                    </div>
                </div>{!! field_help_block('tags', []) !!}
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    {!! Theme::js('js/tag.js') !!}
@endsection