@extends('layout.reactor')

@section('pageTitle', trans('nodes.list'))
@section('contentSubtitle')
    {{ uppercase(trans('nodes.title')) }}
@endsection

@section('action')
    {!! action_button(route('reactor.contents.create', $node->getKey()), 'icon-plus') !!}
@endsection

@section('content')
    @include('partials.nodes.ancestors', [
        'ancestors' => $node->getAncestors()
    ])

    @include('partials.content.header', [
        'headerTitle' => $source->title,
        'headerHint' => $node->getNodeType()->label
    ])

    <div class="material-light">
        @include('nodes.tabs', [
            'currentTab' => 'reactor.contents.list',
            'currentKey' => $node->getKey()
        ])

        @include('nodes.translationtabs', [
            'route' => 'reactor.contents.list'
        ])

        {!! content_table_open(true) !!}
            <th>
                {!! sortable_link('title', uppercase(trans('validation.attributes.title'))) !!}
            </th>
            <th class="content-column-hidden">
                {{ uppercase(trans('validation.attributes.type')) }}
            </th>
            <th>
                {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!}
            </th>
        {!! content_table_middle() !!}
            @if($children->count())
                @include('nodes.content', ['nodes' => $children, 'thumbnails' => false])
            @else
                {!! no_results_row('nodes.no_children') !!}
            @endif

        {!! content_table_close(true) !!}
        <div class="content-footer content-footer-sub">
            @include('partials.pagination', ['pagination' => $children])
        </div>

    </div>

@endsection

@include('partials.content.delete_modal', ['message' => 'nodes.confirm_delete'])